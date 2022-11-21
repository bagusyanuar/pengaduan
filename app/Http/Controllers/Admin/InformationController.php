<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Information;

class InformationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    //admin part
    public function index()
    {
        return view('admin.informasi.index');
    }

    public function information_data()
    {
        try {
            $status = 1;
            if ($this->field('q') === 'answered') {
                $status = 6;
            } else if ($this->field('q') === 'waiting') {
                $status = 0;
            } else if ($this->field('q') === 'complete') {
                $status = 9;
            }
            $query = Information::with(['legal', 'unit', 'ppk'])
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
}
