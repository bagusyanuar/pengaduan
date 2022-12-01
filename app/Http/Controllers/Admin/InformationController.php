<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Mail\InformationDisposition;
use App\Mail\ReplyComplain;
use App\Mail\ReplyInformation;
use App\Models\Complain;
use App\Models\ComplainAnswer;
use App\Models\Information;
use App\Models\InformationAnswer;
use App\Models\PPK;
use App\Models\SatuanKerja;
use App\Models\UserPPK;
use App\Models\UserSatuanKerja;
use App\Models\UserUki;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;
use Symfony\Polyfill\Intl\Idn\Info;

class InformationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    //admin part
    public function index()
    {
        return view('admin.informasi.index');
    }

    public function on_process()
    {
        return view('admin.informasi.on-process');
    }

    public function answered()
    {
        return view('admin.informasi.answered');
    }

    public function finished()
    {
        return view('admin.informasi.finished');
    }

    public function detail($ticket)
    {
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Information::with(['legal', 'unit', 'ppk', 'answers' => function ($q) {
            return $q->orderBy('date_upload', 'DESC');
        }, 'approved_answer', 'answers.upload_by', 'answers.answer_by'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();

        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                setlocale(LC_ALL, 'IND');
                $pdf = Pdf::loadView('admin.surat-pengantar.information', [
                    'data' => $data
                ]);
//                return $pdf->stream();
                $path = 'assets/attachment/' . Uuid::uuid4() . '.pdf';
                $pdf->save($path);
                Mail::to($data->email)->send(new ReplyInformation($data, $path));
                $data->update([
                    'is_finish' => 1,
                    'finish_at' => Carbon::now()->format('Y-m-d')
                ]);
                DB::commit();
                return redirect()->back()->with('success', 'berhasil...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }
        }
        return view('admin.informasi.detail-answer')->with(['data' => $data]);
    }

    public function information_data()
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
            $query = Information::with(['legal', 'unit', 'ppk'])
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
            $information = Information::with('legal')->where('status', '=', 0)
                ->where('id', '=', $id)
                ->first();
            if (!$information) {
                return $this->jsonResponse('Data Tidak Di Temukan...', 202);
            }
            $information->update([
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

    public function information_answers_by_ticket_data($ticket)
    {
        try {
            $ticket_id = str_replace('-', '/', $ticket);
            $data = InformationAnswer::with(['information', 'upload_by', 'answer_by'])->whereHas('information', function ($q) use ($ticket_id) {
                return $q->where('ticket_id', '=', $ticket_id);
            })
                ->orderBy('date_upload', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    //uki part
    public function index_uki()
    {
        return view('uki.informasi.index');
    }

    public function on_process_uki()
    {
        return view('uki.informasi.on-process');
    }

    public function information_data_uki()
    {
        try {
            $limit = $this->field('limit');
            $status = [1];
            if ($this->field('q') === 'answered') {
                $status = [6, 9];
            }
            $query = Information::with(['legal', 'unit', 'ppk'])
                ->whereIn('status', $status);

            if ($this->field('q') === 'process') {
                $query->whereNotNull('target');
            }

            if ($this->field('q') === 'waiting') {
                $query->whereNull('target');
            }

            if ($limit !== null) {
                $query->take((int)$limit);
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
        $data = Information::with(['legal', 'unit', 'ppk'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();
        if ($this->request->method() === 'POST') {
            return $this->send_disposition($data->id);
        }
        $unit = SatuanKerja::all();
        $ppk = PPK::with('unit')->get();
        Session::forget('redirect');
        return view('uki.informasi.detail')->with(['data' => $data, 'unit' => $unit, 'ppk' => $ppk]);
    }

    private function send_disposition($id)
    {
        $data = Information::with('legal')
            ->findOrFail($id);

        if ($this->postField('status') === '1') {
            $data_update = [
                'target' => $this->postField('target'),
                'description' => 'Jawaban permintaan informasi di terima'
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
            foreach ($mails_to as $target) {
                Mail::to($target['email'])->send(new InformationDisposition($data, $target['target']));
            }
        } else {
            $data_update = [
                'description' => $this->postField('description'),
                'status' => 6
            ];
            $data->update($data_update);
        }
        return redirect()->back()->with('success', 'Berhasil melakukan konfirmasi permintaan informasi...');
    }

    public function information_answers_by_ticket($ticket)
    {
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Information::with(['legal', 'unit', 'ppk', 'answers' => function ($q) {
            return $q->orderBy('date_upload', 'DESC');
        }, 'answer', 'answers.upload_by', 'answers.answer_by'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();
//        return $data->toArray();
        if ($this->request->method() === 'POST') {
            return $this->response_answer($data);
        }
        return view('uki.informasi.jawaban')->with(['data' => $data]);
    }

    private function response_answer($information)
    {
        DB::beginTransaction();
        try {
            $status = $this->postField('status');
            $data = [
                'date_answer' => Carbon::now()->format('Y-m-d'),
                'status' => $status === '1' ? 9 : 6,
                'author_answer' => Auth::id(),
                'description' => 'Jawaban permintaan informasi di terima'
            ];
            if ($status === '0') {
                $data['description'] = $this->postField('description');
            }
            $information->answer->update($data);
            if ($status === '1') {
                $information->update([
                    'status' => 9
                ]);
            }
            DB::commit();
            return redirect()->route('information.process.uki')->with('success', 'Berhasil Melakukan Konfirmasi Jawaban Permintaan Informasi...');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
        }

    }


    public function reply_information($id)
    {
        try {
            DB::beginTransaction();
            $information = Information::with('legal')
                ->where('id', '=', $id)
                ->first();
            if (!$information) {
                return $this->jsonResponse('Data Tidak Di Temukan...', 500);
            }
            $information->update([
                'is_finish' => 1,
                'finish_at' => Carbon::now()->format('Y-m-d')
            ]);
            $target = $information->email;
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
        return view('ppk.informasi.index');
    }

    public function information_data_ppk()
    {

        try {
            $limit = $this->field('limit');
            $user_ppk = UserPPK::where('user_id', '=', Auth::id())->first();
            if (!$user_ppk) {
                return $this->basicDataTables([]);
            }
            $status = 1;
            $query = Information::with(['legal', 'last_answer'])
                ->where('status', '=', $status)
                ->where('target', '=', 1);
            if ($this->field('q') === 'waiting') {
                $query->where('ppk_id', '=', $user_ppk->ppk_id);
            }
            if ($limit !== null) {
                $query->take((int)$limit);
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
        $data = Information::with(['legal', 'unit', 'ppk', 'answers'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail()->append(['HasAnswer', 'HasApprovedAnswer']);
        if ($this->request->method() === 'POST') {
            return $this->send_answer($data);
        }
        Session::forget('redirect');
        return view('ppk.informasi.detail')->with(['data' => $data]);
    }

    public function information_answers_data($ticket)
    {
        try {
            $ticket_id = str_replace('-', '/', $ticket);
            $data = InformationAnswer::with(['information', 'upload_by', 'answer_by'])
                ->whereHas('information', function ($q) use ($ticket_id) {
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

    private function send_answer($data)
    {
        DB::beginTransaction();
        try {
            $data_request = [
                'information_id' => $data->id,
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
            InformationAnswer::create($data_request);
            $users_uki = UserUki::with('user')->get();
            foreach ($users_uki as $user_uki) {
                $target = $user_uki->user->email;
                Mail::to($target)->send(new \App\Mail\InformationAnswer($data));
            }
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Melakukan Konfirmasi Permintaan Informasi...');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'terjadi kesalahan server');
        }
    }

    //satker part
    public function index_satker()
    {
        return view('satker.informasi.index');
    }

    public function information_data_satker()
    {

        try {
            $limit = $this->field('limit');
            $user_satker = UserSatuanKerja::where('user_id', '=', Auth::id())->first();
            if (!$user_satker) {
                return $this->basicDataTables([]);
            }
            $status = 1;
            $query = Information::with(['legal', 'last_answer'])
                ->where('status', '=', $status)
                ->where('target', '=', 0);
            if ($this->field('q') === 'waiting') {
                $query->where('satker_id', '=', $user_satker->satker_id);
            }

            if ($limit !== null) {
                $query->take((int)$limit);
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
        $data = Information::with(['legal', 'unit', 'ppk', 'answers'])->where('ticket_id', '=', $ticket_id)
            ->firstOrFail()->append(['HasAnswer', 'HasApprovedAnswer']);
        if ($this->request->method() === 'POST') {
            return $this->send_answer($data);
        }
        Session::forget('redirect');
        return view('satker.informasi.detail')->with(['data' => $data]);
    }
}
