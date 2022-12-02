<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\ComplainAnswer;
use App\Models\Information;
use App\Models\PPK;
use App\Models\UserPPK;
use App\Models\UserSatuanKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Dashboard extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $new_complain = Complain::where('status', '=', 0)->count();
        $new_information = Information::where('status', '=', 0)->count();
        return view('admin.dashboard')->with(['new_complain' => $new_complain, 'new_information' => $new_information]);
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
        $new_complain = Complain::with(['legal', 'unit', 'ppk'])
            ->whereIn('status', [1])
            ->whereNull('target')->count();
        $new_information = Information::with(['legal', 'unit', 'ppk'])
            ->whereIn('status', [1])
            ->whereNull('target')->count();
        return view('uki.dashboard-uki')->with(['new_complain' => $new_complain, 'new_information' => $new_information]);
    }

    public function index_satker()
    {
        $new_complain = 0;
        $new_information = 0;
        $user_satker = UserSatuanKerja::where('user_id', '=', Auth::id())->first();
        if ($user_satker) {
            $new_complain = Complain::with([])
                ->where('status', '=', 1)
                ->where('target', '=', 0)
                ->where('satker_id', '=', $user_satker->satker_id)
                ->count();
            $new_information = Information::with([])
                ->where('status', '=', 1)
                ->where('target', '=', 0)
                ->where('satker_id', '=', $user_satker->satker_id)
                ->count();
        }

        return view('satker.dashboard')->with(['new_complain' => $new_complain, 'new_information' => $new_information]);
    }

    public function index_ppk()
    {
        $new_complain = 0;
        $new_information = 0;
        $user_ppk = UserPPK::where('user_id', '=', Auth::id())->first();
        if ($user_ppk) {
            $new_complain = Complain::with([])
                ->where('status', '=', 1)
                ->where('target', '=', 1)
                ->where('ppk_id', '=', $user_ppk->ppk_id)
                ->count();
            $new_information = Information::with([])
                ->where('status', '=', 1)
                ->where('target', '=', 1)
                ->where('ppk_id', '=', $user_ppk->ppk_id)
                ->count();
        }
        return view('ppk.dashboard')->with(['new_complain' => $new_complain, 'new_information' => $new_information]);
    }


}
