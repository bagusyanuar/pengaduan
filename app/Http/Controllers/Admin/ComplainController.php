<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;

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
//    public function set_to_finish()
//    {
//        try {
//
//        }catch (\Exception $e) {
//
//        }
//    }
}
