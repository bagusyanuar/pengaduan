<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\ComplainAnswer;
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
        $data = Complain::with('legal')->orderBy('created_at', 'DESC')->limit(10)->get();
        $answers = Complain::with('answers')
            ->whereHas('answers', function ($q) {
                return $q->where('status', '=', 9);
            })
            ->orderBy('date', 'ASC')
            ->get();
        return view('admin.dashboard')->with(['data' => $data, 'answers' => $answers]);
    }

    public function index_uki()
    {
        return view('uki.dashboard-uki');
    }

    public function index_satker()
    {
        return \view('satker.dashboard');
    }

    public function complain_data()
    {
        try {
            $data = Complain::with('legal')->orderBy('id', 'DESC')->limit(10)->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
