<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Complain;

class Dashboard extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Complain::with('legal')->orderBy('created_at', 'DESC')->limit(10)->get();
        return view('admin.dashboard')->with(['data' => $data]);
    }
}
