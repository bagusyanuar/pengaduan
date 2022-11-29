<?php


namespace App\Http\Controllers;

use App\Mail\InformationBaru;
use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\Information;
use App\Models\LegalComplain;
use App\Models\LegalInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InformationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            if ($this->postField('type') === '1') {
                return $this->post_new_legal_information();
            } else {
                return $this->post_new_information();
            }
        }
        return view('information');
    }

    private function post_new_information()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
                'card_id' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'information' => 'required',
                'purpose' => 'required',
            ], [
                'name.required' => 'Kolom nama wajib di isi',
                'card_id.required' => 'Kolom ktp wajib di isi',
                'email.required' => 'Kolom email wajib di isi',
                'email.email' => 'Format kolom email tidak valid',
                'phone.required' => 'Kolom No. Whatsapp wajib di isi',
                'address.required' => 'Kolom alamat wajib di isi',
                'information.required' => 'Kolom rincian informasi wajib di isi',
                'purpose.required' => 'Kolom tujuan informasi  wajib di isi',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput(request()->input())->withErrors($validator->errors());
            }
            $formatted_ticket = $this->generate_new_ticket();
            $data = [
                'ticket_id' => $formatted_ticket,
                'date' => Carbon::now()->format('Y-m-d'),
                'card_id' => $this->postField('card_id'),
                'name' => $this->postField('name'),
                'address' => $this->postField('address'),
                'job' => $this->postField('job'),
                'phone' => '62' . $this->postField('phone'),
                'email' => $this->postField('email'),
                'information' => $this->postField('information'),
                'information_source' => $this->postField('information_source'),
                'purpose' => $this->postField('purpose'),
                'source' => $this->postField('source'),
                'type' => $this->postField('type'),
                'status' => 0,
                'description' => '-'
            ];
            $information = Information::create($data);
		 	$admin = User::where('role', 'admin')->first();
			$emailpemohon = $this->postField('email');
			$targetArray = [$admin->email, $emailpemohon];
            foreach ($targetArray as $target) {
                Mail::to($target)->send(new InformationBaru($information));
            } 
            return redirect()->route('information.success')->with('success', 'Berhasil Mengirimkan Saran / Pengaduan...')->with('ticket', $information->ticket_id);
        } catch (\Exception $e) {
            return redirect()->back()->withInput(request()->input())->with('failed', 'Terjadi kesalahan server...' . $e->getMessage());
        }
    }

    private function post_new_legal_information()
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($this->request->all(), [
                'legal_name' => 'required',
                'legal_card_id' => 'required',
                'legal_email' => 'required|email',
                'legal_phone' => 'required',
                'legal_address' => 'required',
                'legal_information' => 'required',
                'legal_purpose' => 'required',
                'legal_assignment' => 'required|mimes:pdf',
                'legal_ad_art' => 'required|mimes:pdf',
            ], [
                'legal_name.required' => 'Kolom nama wajib di isi',
                'legal_card_id.required' => 'Kolom ktp wajib di isi',
                'legal_email.required' => 'Kolom email wajib di isi',
                'legal_information.required' => 'Kolom rincian informasi wajib di isi',
                'legal_purpose.required' => 'Kolom tujuan permintaan informasi wajib di isi',
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
                'card_id' => $this->postField('legal_card_id'),
                'name' => $this->postField('legal_name'),
                'address' => $this->postField('legal_address'),
                'job' => $this->postField('legal_job'),
                'phone' => '62' . $this->postField('legal_phone'),
                'email' => $this->postField('legal_email'),
                'information' => $this->postField('legal_information'),
                'information_source' => $this->postField('legal_information_source'),
                'purpose' => $this->postField('legal_purpose'),
                'source' => $this->postField('legal_source'),
                'type' => $this->postField('type'),
                'status' => 0,
                'description' => '-'
            ];
            $information = Information::create($data);
            $data_legal = [
                'information_id' => $information->id
            ];
            if ($this->request->hasFile('legal_assignment')) {
                $file = $this->request->file('legal_assignment');
                $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                $file_name = '/assets/legal/' . $name;
                Storage::disk('legal')->put($name, File::get($file));
                $data_legal['assignment'] = $file_name;
            } else {
                DB::rollBack();
                return redirect()->back()->withInput(request()->input())->with('failed', 'File Surat Kuasa Belum Terlampir...');
            }

            if ($this->request->hasFile('legal_ad_art')) {
                $file = $this->request->file('legal_ad_art');
                $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                $file_name = '/assets/legal/' . $name;
                Storage::disk('legal')->put($name, File::get($file));
                $data_legal['ad_art'] = $file_name;
            } else {
                DB::rollBack();
                return redirect()->back()->withInput(request()->input())->with('failed', 'File Surat Kuasa Belum Terlampir...');
            }
            LegalInformation::create($data_legal);
            DB::commit();
			$admin = User::where('role', 'admin')->first();
			$emailpemohon = $this->postField('legal_email');
			$targetArray = [$admin->email, $emailpemohon];
            foreach ($targetArray as $target) {
                Mail::to($target)->send(new InformationBaru($information));
            } 
            return redirect()->route('information.success')->with('success', 'Berhasil Mengirimkan Saran / Pengaduan...')->with('ticket', $information->ticket_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput(request()->input())->with('failed', 'Terjadi kesalahan server...' . $e->getMessage())->with('legal', '');
        }
    }

    private function generate_new_ticket()
    {
        $now = Carbon::now()->format('m/Y');
        $last_information = Information::where('ticket_id', 'LIKE', '%' . $now)->orderBy('id', 'DESC')->first();
        $formatted_number = '001';
        if ($last_information) {
            $suffix_code = (int)substr($last_information->ticket_id, 0, 3);
            $formatted_number = sprintf('%03d', ($suffix_code + 1));
        }
        return $formatted_number . '/PPID/BM/PUPR/PIP/' . $now;
    }

    public function success()
    {
        if (!Session::has('ticket')) {
            return redirect()->route('home');
        }
		
        return view('information-success');
    }
}
