<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\LegalComplain;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComplainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        if ($this->request->method() === 'POST') {
            if ($this->postField('type') === '1') {
                return $this->post_new_legal_complain();
            } else {
                return $this->post_new_complain();
            }
        }
        return view('complain');
    }

    private function post_new_complain()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'complain' => 'required',
            ], [
                'name.required' => 'Kolom nama wajib di isi',
                'email.required' => 'Kolom email wajib di isi',
                'email.email' => 'Format kolom email tidak valid',
                'phone.required' => 'Kolom No. Whatsapp wajib di isi',
                'address.required' => 'Kolom alamat wajib di isi',
                'complain.required' => 'Kolom saran / pengaduan wajib di isi',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput(request()->input())->withErrors($validator->errors());
            }
            $formatted_ticket = $this->generate_new_ticket();
            $data = [
                'ticket_id' => $formatted_ticket,
                'date' => Carbon::now()->format('Y-m-d'),
                'name' => $this->postField('name'),
                'address' => $this->postField('address'),
                'job' => $this->postField('job'),
                'phone' => '62' . $this->postField('phone'),
                'email' => $this->postField('email'),
                'complain' => $this->postField('complain'),
                'type' => $this->postField('type'),
                'status' => 0,
                'description' => '-'
            ];
            $complain = Complain::create($data);
            return redirect()->route('complain.success')->with('success', 'Berhasil Mengirimkan Saran / Pengaduan...')->with('ticket', $complain->ticket_id);
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Terjadi kesalahan server...');
        }
    }

    private function post_new_legal_complain()
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($this->request->all(), [
                'legal_name' => 'required',
                'legal_email' => 'required|email',
                'legal_phone' => 'required',
                'legal_address' => 'required',
                'legal_complain' => 'required',
                'legal_assignment' => 'required|mimes:pdf',
                'legal_ad_art' => 'required|mimes:pdf',
            ], [
                'legal_name.required' => 'Kolom nama wajib di isi',
                'legal_email.required' => 'Kolom email wajib di isi',
                'legal_email.email' => 'Format kolom email tidak valid',
                'legal_phone.required' => 'Kolom No. Whatsapp wajib di isi',
                'legal_address.required' => 'Kolom alamat wajib di isi',
                'legal_complain.required' => 'Kolom saran / pengaduan wajib di isi',
                'legal_assignment.required' => 'Surat kuasa wajib di lampirkan',
                'legal_ad_art.required' => 'AD ADRT wajib di lampirkan',
                'legal_assignment.mimes' => 'File surat kuasa harus berupa file pdf',
                'legal_ad_art.mimes' => 'File AD ADRT harus berupa file pdf',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput(request()->input())->withErrors($validator->errors())->with('legal', '');
            }
            $formatted_ticket = $this->generate_new_ticket();
            $data = [
                'ticket_id' => $formatted_ticket,
                'date' => Carbon::now()->format('Y-m-d'),
                'name' => $this->postField('legal_name'),
                'address' => $this->postField('legal_address'),
                'job' => $this->postField('legal_job'),
                'phone' => '62' . $this->postField('legal_phone'),
                'email' => $this->postField('legal_email'),
                'complain' => $this->postField('legal_complain'),
                'type' => $this->postField('type'),
                'status' => 0,
                'description' => '-'
            ];
            $complain = Complain::create($data);
            $data_legal = [
                'complain_id' => $complain->id
            ];
            if ($this->request->hasFile('legal_assignment')) {
                $file = $this->request->file('legal_assignment');
                $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                $file_name = '/assets/legal/' . $name;
                Storage::disk('legal')->put($name, File::get($file));
                $data_legal['assignment'] = $file_name;
            } else {
                DB::rollBack();
                return redirect()->back()->with('failed', 'File Surat Kuasa Belum Terlampir...');
            }

            if ($this->request->hasFile('legal_ad_art')) {
                $file = $this->request->file('legal_ad_art');
                $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                $file_name = '/assets/legal/' . $name;
                Storage::disk('legal')->put($name, File::get($file));
                $data_legal['ad_art'] = $file_name;
            } else {
                DB::rollBack();
                return redirect()->back()->with('failed', 'File Surat Kuasa Belum Terlampir...');
            }
            LegalComplain::create($data_legal);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Mengirimkan Saran / Pengaduan...')->with('legal', '');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan server...' . $e->getMessage())->with('legal', '');
        }
    }

    private function generate_new_ticket()
    {
        $now = Carbon::now()->format('m/Y');
        $last_complain = Complain::where('ticket_id', 'LIKE', '%' . $now)->orderBy('id', 'DESC')->first();
        $formatted_number = '001';
        if ($last_complain) {
            $suffix_code = (int)substr($last_complain->ticket_id, 0, 3);
            $formatted_number = sprintf('%03d', ($suffix_code + 1));
        }
        return $formatted_number . '/PPID/BM/PUPR/SP/' . $now;
    }

    public function success()
    {
//        if (!Session::has('ticket')) {
//            return redirect()->route('home');
//        }
        return view('complain-succes');
    }
}
