<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\PPK;
use App\Models\SatuanKerja;
use Illuminate\Support\Facades\Session;
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

    public function index_uki()
    {
        return view('uki.pengaduan.index');
    }

    public function complain_data()
    {
        try {
            $status = 0;
            if ($this->field('q') === 'answered') {
                $status = 6;
            } else if ($this->field('q') === 'process') {
                $status = 1;
            } else if ($this->field('q') === 'complete') {
                $status = 9;
            }
            $query = Complain::with('legal')
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
            $data = $query->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function data_detail_by_ticket($ticket)
    {
        Session::put('redirect', URL::current());
        $ticket_id = str_replace('-', '/', $ticket);
        $data = Complain::with('legal')->where('ticket_id', '=', $ticket_id)
            ->firstOrFail();
        $unit = SatuanKerja::all();
        $ppk = PPK::with('unit')->get();
        Session::forget('redirect');
        return view('uki.pengaduan.detail')->with(['data' => $data, 'unit' => $unit, 'ppk' => $ppk]);
    }

    public function send_disposition($id)
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
            dd('tolak');
        }
        return redirect()->back();
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
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }
//    public function set_to_finish()
//    {
//        try {
//
//        }catch (\Exception $e) {
//
//        }
//    }
}
