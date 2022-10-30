<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;

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

    public function complain_data()
    {
        try {
            $data = Complain::with('legal')
                ->where('status', '=', 0)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
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
