<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Complain;
use Carbon\Carbon;

class ComplainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $now = Carbon::now()->format('m/Y');
            $last_complain = Complain::where('ticket_id', 'LIKE', '%' . $now)->orderBy('id', 'DESC')->first();
            $formatted_number = '001';
            if ($last_complain) {
                $suffix_code = (int)substr($last_complain->ticket_id, 0, 3);
                $formatted_number = sprintf('%03d', ($suffix_code + 1));
            }
            $formatted_ticket = $formatted_number . '/PPID/BM/PUPR/SP/' . $now;
            $data = [
                'ticket_id' => $formatted_ticket,
                'date' => Carbon::now()->format('Y-m-d'),
                'name' => $this->postField('name'),
                'address' => $this->postField('address'),
                'job' => $this->postField('job'),
                'phone' => $this->postField('phone'),
                'email' => $this->postField('email'),
                'complain' => $this->postField('complain'),
                'type' => $this->postField('type'),
                'status' => 0,
                'description' => '-'
            ];
            Complain::create($data);
            return redirect()->back()->with('success', 'Berhasil Mengirimkan Saran / Pengaduan...');
        }
        return view('complain');
    }
}
