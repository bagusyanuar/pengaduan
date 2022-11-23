<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\ComplainAnswer;
use App\Models\Information;
use App\Models\PPK;
use Illuminate\View\View;

class Dashboard extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Complain::with('answers')
            ->where('status', '=', 7)
//            ->whereHas('answers', function ($q) {
//                return $q->where('status', '=', 9);
//            })
            ->orderBy('date', 'ASC')
            ->get();
        $new_complain = Complain::where('status', '=', 0)->count();
        $new_information = Information::where('status', '=', 0)->count();
        return view('admin.dashboard')->with(['data' => $data, 'new_complain' => $new_complain, 'new_information' => $new_information]);
    }

    public function complain_data()
    {
        try {
            $data = Complain::with('legal')->orderBy('id', 'DESC')->limit(5)->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function index_uki()
    {
        return view('uki.dashboard-uki');
    }

    public function index_satker()
    {
        return view('satker.dashboard');
    }

    public function index_ppk()
    {
        return view('ppk.dashboard');
    }


}
