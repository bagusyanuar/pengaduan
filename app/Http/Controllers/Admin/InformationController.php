<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Information;
use App\Models\UserUki;
use Carbon\Carbon;
use Symfony\Polyfill\Intl\Idn\Info;

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

    public function on_process()
    {
        return view('admin.informasi.on-process');
    }
    public function information_data()
    {
        try {
            $limit = $this->field('limit');
            $completed = false;
            $status = [1];
            if ($this->field('q') === 'complete') {
                $completed = true;
                $status = [6, 9];
            }
            if ($this->field('q') === 'answered') {
                $status = [6, 9];
            } else if ($this->field('q') === 'waiting') {
                $status = [0];
            }
            $query = Information::with(['legal', 'unit', 'ppk'])
                ->whereIn('status', $status)
                ->where('is_finish', '=', $completed);

            if ($this->field('q') === 'complete') {
                $start = Carbon::parse($this->field('start_date'))->format('Y-m-d');
                $end = Carbon::parse($this->field('end_date'))->format('Y-m-d');
                $query->whereBetween('date', [$start, $end]);
            }

            if ($limit !== null) {
                $query->take((int)$limit);
            }
            $data = $query->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function send_process($id)
    {
        try {
            $information = Information::with('legal')->where('status', '=', 0)
                ->where('id', '=', $id)
                ->first();
            if (!$information) {
                return $this->jsonResponse('Data Tidak Di Temukan...', 202);
            }
            $information->update([
                'status' => 1
            ]);
            $users_uki = UserUki::with('user')->get();
//            foreach ($users_uki as $user_uki) {
//                $target = $user_uki->user->email;
//                Mail::to($target)->send(new NewComplain($complain));
//            }
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }


    //uki part
    public function index_uki()
    {
        return view('uki.informasi.index');
    }

    public function on_process_uki()
    {
        return view('uki.informasi.on-process');
    }

    public function information_data_uki()
    {
        try {
            $status = [1];
            if ($this->field('q') === 'answered') {
                $status = [6, 9];
            }
            $query = Information::with(['legal', 'unit', 'ppk'])
                ->whereIn('status', $status);

            if ($this->field('q') === 'process') {
                $query->whereNotNull('target');
            }

            if ($this->field('q') === 'waiting') {
                $query->whereNull('target');
            }
            $data = $query->get()->append(['HasAnswer']);
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
