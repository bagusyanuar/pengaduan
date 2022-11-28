<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Mail\ComplainDisposition;
use App\Mail\NewComplain;
use App\Mail\ReplyComplain;
use App\Models\Complain;
use App\Models\ComplainAnswer;
use App\Models\PPK;
use App\Models\SatuanKerja;
use App\Models\UserPPK;
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
            $limit = $this->field('limit');
            $completed = false;
            $status = [1];
            if ($this->field('q') === 'complete') {
                $completed = true;
                $status = [6, 9];
            }
            if ($this->field('q') === 'answered') {
                $status = [6, 9];
            } else if ($this->field('q') === 'waiting') {
                $status = [0];
            }
            $query = Complain::with(['legal', 'unit', 'ppk'])
                ->whereIn('status', $status)
                ->where('is_finish', '=', $completed);

            if ($this->field('q') === 'complete') {
                $start = Carbon::parse($this->field('start_date'))->format('Y-m-d');
                $end = Carbon::parse($this->field('end_date'))->format('Y-m-d');
                $query->whereBetween('date', [$start, $end]);
            }
            if ($limit !== null) {
                $query->take((int)$limit);
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
//            foreach ($users_uki as $user_uki) {
//                $target = $user_uki->user->email;
//                Mail::to($target)->send(new NewComplain($complain));
//            }
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
            $status = [1];
            if ($this->field('q') === 'answered') {
                $status = [6, 9];
            }
            $query = Complain::with(['legal', 'unit', 'ppk'])
                ->whereIn('status', $status);

            if ($this->field('q') === 'process') {
                $query->whereNotNull('target');
            }

            if ($this->field('q') === 'waiting') {
                $query->whereNull('target');
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
            $mails_to = [];
            if ($this->postField('target') === '1') {
                //send to ppk
                $ppk = PPK::with('unit')->find($this->postField('ppk'));
                $data_update['ppk_id'] = $ppk->id;
                $data_update['satker_id'] = $ppk->unit->id;

                $users_ppk = UserPPK::with(['user'])->where('ppk_id', '=', $ppk->id)->get();
                $users_satker = UserSatuanKerja::with(['user'])->where('satker_id', '=', $ppk->unit->id)->get();
                foreach ($users_ppk as $user_ppk) {
                    array_push($mails_to, ['email' => $user_ppk->user->email, 'target' => 'ppk']);
                }

                foreach ($users_satker as $user_satker) {
                    array_push($mails_to, ['email' => $user_satker->user->email, 'target' => 'satker']);
                }
            } else {
                //send to satker
                $unit = SatuanKerja::find($this->postField('unit'));
                $data_update['satker_id'] = $unit->id;

                $users_satker = UserSatuanKerja::with(['user'])->where('satker_id', '=', $unit->id)->get();

                foreach ($users_satker as $user_satker) {
                    array_push($mails_to, ['email' => $user_satker->user->email, 'target' => 'satker']);
                }
            }
            $data->update($data_update);
//            foreach ($mails_to as $target) {
//                Mail::to($target['email'])->send(new ComplainDisposition($data, $target['target']));
//            }
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
        }, 'answer', 'answers.upload_by', 'answers.answer_by'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();
        if ($this->request->method() === 'POST') {
            return $this->response_answer($data);
        }
        return view('uki.pengaduan.jawaban')->with(['data' => $data]);
    }

    public function complain_answers_by_ticket_data($ticket)
    {
        try {
            $ticket_id = str_replace('-', '/', $ticket);
            $data = ComplainAnswer::with(['complain', 'upload_by', 'answer_by'])->whereHas('complain', function ($q) use ($ticket_id) {
                return $q->where('ticket_id', '=', $ticket_id);
            })
                ->orderBy('date_upload', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }

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
                'description' => 'Jawaban saran / pengaduan di terima'
            ];
            if ($status === '0') {
                $data['description'] = $this->postField('description');
            }
            $complain->answer->update($data);
            if ($status === '1') {
                $complain->update([
                    'status' => 9
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
            $query = Complain::with(['legal', 'last_answer'])
                ->where('status', '=', $status)
                ->where('target', '=', 0);
            if ($this->field('q') === 'waiting') {
                $query->where('satker_id', '=', $user_satker->satker_id);
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
        $data = Complain::with(['legal', 'unit', 'ppk', 'answers'])->where('ticket_id', '=', $ticket_id)
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

    public function reply_complain($id)
    {
        try {
            DB::beginTransaction();
            $complain = Complain::with('legal')
                ->where('id', '=', $id)
                ->first();
            if (!$complain) {
                return $this->jsonResponse('Data Tidak Di Temukan...', 500);
            }
            $complain->update([
                'is_finish' => 1,
                'finish_at' => Carbon::now()->format('Y-m-d')
            ]);
            $target = $complain->email;
//            Mail::to($target)->send(new ReplyComplain($complain));
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('terjadi kesalahan ', 500);
        }
    }


    //ppk part
    public function index_ppk()
    {
        return view('ppk.pengaduan.index');
    }

    public function complain_data_ppk()
    {

        try {
            $user_ppk = UserPPK::where('user_id', '=', Auth::id())->first();
            if (!$user_ppk) {
                return $this->basicDataTables([]);
            }
            $status = 1;
            $query = Complain::with(['legal', 'last_answer'])
                ->where('status', '=', $status)
                ->where('target', '=', 1);
            if ($this->field('q') === 'waiting') {
                $query->where('ppk_id', '=', $user_ppk->ppk_id);
            }
            $data = $query->get()->append(['HasAnswer', 'HasApprovedAnswer']);
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function data_detail_by_ticket_ppk($ticket)
    {
        Session::put('redirect', URL::current());
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Complain::with(['legal', 'unit', 'ppk', 'answers'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail()->append(['HasAnswer', 'HasApprovedAnswer']);
        if ($this->request->method() === 'POST') {
            return $this->send_answer($data->id);
        }
        Session::forget('redirect');
        return view('ppk.pengaduan.detail')->with(['data' => $data]);
    }

    public function complain_answers_data($ticket)
    {
        try {
            $ticket_id = str_replace('-', '/', $ticket);
            $data = ComplainAnswer::with(['complain', 'author_upload', 'author_answer'])
                ->whereHas('complain', function ($q) use ($ticket_id) {
                    return $q->where('ticket_id', '=', $ticket_id);
                })
                ->orderBy('date_upload', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
