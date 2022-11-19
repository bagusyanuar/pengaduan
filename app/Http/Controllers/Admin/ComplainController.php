<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Mail\NewComplain;
use App\Models\Complain;
use App\Models\ComplainAnswer;
use App\Models\PPK;
use App\Models\SatuanKerja;
use App\Models\UserSatuanKerja;
use App\Models\UserUki;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ComplainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.pengaduan.index');
    }

    public function on_process()
    {
        return view('admin.pengaduan.on-process');
    }

    public function answered()
    {
        return view('admin.pengaduan.answered');
    }

    public function finished()
    {
        return view('admin.pengaduan.finished');
    }

    public function complain_data()
    {
        try {
            $status = 1;
            if ($this->field('q') === 'answered') {
                $status = 6;
            } else if ($this->field('q') === 'waiting') {
                $status = 0;
            } else if ($this->field('q') === 'complete') {
                $status = 9;
            }
            $query = Complain::with(['legal', 'unit', 'ppk'])
                ->where('status', '=', $status);
            if ($this->field('q') === 'answered') {
                $query->orWhere('status', '=', 7);
            }
            $data = $query->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function send_process($id)
    {
        try {
            $complain = Complain::with('legal')->where('status', '=', 0)
                ->where('id', '=', $id)
                ->first();
            if (!$complain) {
                return $this->jsonResponse('Data Tidak Di Temukan...', 202);
            }
            $complain->update([
                'status' => 1
            ]);
            $users_uki = UserUki::with('user')->get();
            foreach ($users_uki as $user_uki) {
                $target = $user_uki->user->email;
                Mail::to($target)->send(new NewComplain($complain));
            }
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }

    //uki part
    public function index_uki()
    {
        return view('uki.pengaduan.index');
    }

    public function on_process_uki()
    {
        return view('uki.pengaduan.on-process');
    }

    public function complain_data_uki()
    {
        try {
            $status = 1;
            if ($this->field('q') === 'answered') {
                $status = 6;
            }
            $query = Complain::with('legal')
                ->where('status', '=', $status);
            if ($this->field('q') === 'answered') {
                $query->orWhere('status', '=', 7);
            }

            if ($this->field('q') === 'process') {
                $query->whereNotNull('satker_id');
            }

            if ($this->field('q') === 'waiting') {
                $query->whereNull('satker_id');
            }
            $data = $query->get()->append(['HasAnswer']);
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function data_detail_by_ticket($ticket)
    {
        Session::put('redirect', URL::current());
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Complain::with(['legal', 'unit', 'ppk'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();
        if ($this->request->method() === 'POST') {
            return $this->send_disposition($data->id);
        }
        $unit = SatuanKerja::all();
        $ppk = PPK::with('unit')->get();
        Session::forget('redirect');
        return view('uki.pengaduan.detail')->with(['data' => $data, 'unit' => $unit, 'ppk' => $ppk]);
    }

    private function send_disposition($id)
    {
        $data = Complain::with('legal')
            ->findOrFail($id);
        if ($this->postField('status') === '1') {
            $data_update = [
                'target' => $this->postField('target'),
                'description' => 'Approved'
            ];
            if ($this->postField('target') === '1') {
                $ppk = PPK::with('unit')->find($this->postField('ppk'));
                $data_update['ppk_id'] = $ppk->id;
                $data_update['satker_id'] = $ppk->unit->id;
            } else {
                $unit = SatuanKerja::find($this->postField('unit'));
                $data_update['satker_id'] = $unit->id;
            }
            $data->update($data_update);

        } else {
            $data_update = [
                'description' => $this->postField('description'),
                'status' => 6
            ];
            $data->update($data_update);
        }
        return redirect()->back()->with('success', 'Berhasil Melakukan Konfirmasi Saran / Pengaduan...');
    }

    public function complain_answers_by_ticket($ticket)
    {
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Complain::with(['legal', 'unit', 'ppk', 'answers' => function ($q) {
            return $q->orderBy('date_upload', 'DESC');
        }, 'answer'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();

        if ($this->request->method() === 'POST') {
            return $this->response_answer($data);
        }
        return view('uki.pengaduan.jawaban')->with(['data' => $data]);
    }

    private function response_answer($complain)
    {
        DB::beginTransaction();
        try {
            $status = $this->postField('status');
            $data = [
                'date_answer' => Carbon::now()->format('Y-m-d'),
                'status' => $status === '1' ? 9 : 6,
                'author_answer' => Auth::id(),
                'description' => 'Accepted'
            ];
            if ($status === '0') {
                $data['description'] = $this->postField('description');
            }
            $complain->answer->update($data);
            if ($status === '1') {
                $complain->update([
                    'status' => 7
                ]);
            }
            DB::commit();
            return redirect()->route('complain.process.uki')->with('success', 'Berhasil Melakukan Konfirmasi Jawaban Saran / Pengaduan...');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
        }

    }


    //satker part
    public function index_satker()
    {
        return view('satker.pengaduan.index');
    }

    public function complain_data_satker()
    {

        try {
            $user_satker = UserSatuanKerja::where('user_id', '=', Auth::id())->first();
            if (!$user_satker) {
                return $this->basicDataTables([]);
            }
            $status = 1;
//            if ($this->field('q') === 'answered') {
//                $status = 6;
//            }
            $query = Complain::with('legal')
                ->where('status', '=', $status)
                ->where('target', '=', 0);
//            if ($this->field('q') === 'answered') {
//                $query->orWhere('status', '=', 7);
//            }
//
//            if ($this->field('q') === 'process') {
//                $query->whereNotNull('satker_id');
//            }

            if ($this->field('q') === 'waiting') {
                $query->where('satker_id', '=', $user_satker->satker_id)
                    ->whereNull('ppk_id');
            }
            $data = $query->get()->append(['HasAnswer', 'HasApprovedAnswer']);
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function data_detail_by_ticket_satker($ticket)
    {
        Session::put('redirect', URL::current());
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Complain::with(['legal', 'unit', 'ppk'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail()->append(['HasAnswer', 'HasApprovedAnswer']);
        if ($this->request->method() === 'POST') {
            return $this->send_answer($data->id);
        }
        Session::forget('redirect');
        return view('satker.pengaduan.detail')->with(['data' => $data]);
    }

    private function send_answer($id)
    {
        try {
            $data_request = [
                'complain_id' => $id,
                'date_upload' => Carbon::now()->format('Y-m-d'),
                'status' => 0,
                'description' => '-',
                'author_upload' => Auth::id()
            ];
            if ($this->request->hasFile('answer')) {
                $file = $this->request->file('answer');
                $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                $file_name = '/assets/answers/' . $name;
                Storage::disk('answers')->put($name, File::get($file));
                $data_request['file'] = $file_name;
            } else {
                return redirect()->back()->with('failed', 'File Jawaban Belum Terlampir...');
            }
            ComplainAnswer::create($data_request);
            return redirect()->back()->with('success', 'Berhasil Melakukan Konfirmasi Saran / Pengaduan...');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'terjadi kesalahan server');
        }
    }
}
