<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Complain;
use App\Models\Information;

class TracingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('tracing');
    }

    public function tracing_result($ticket)
    {
        $ticket_id = str_replace('-', '/', $ticket);
        $exp_ticket = explode('/', $ticket_id);
        if (count($exp_ticket) !== 7) {
            dd('error');
        }
        $type = $exp_ticket[4] === 'SP' ? 'complain' : 'information';
        $data = null;
        $step = 1;
        if ($type === 'complain') {
            $data = Complain::with(['ppk', 'unit', 'answers'])
                ->where('ticket_id', '=', $ticket_id)
                ->firstOrFail();

            if (($data->status === 1 && $data->target === null) || ($data->status === 6 && $data->is_finish == false)) {
                $step = 2;
            } elseif ($data->status === 1 && $data->target !== null) {
                $step = 3;
            } elseif ($data->status === 9 && $data->is_finish == false) {
                $step = 3;
            } elseif (($data->status === 6 || $data->status === 9) && $data->is_finish == true) {
                $step = 4;
            }
        } else {
            $data = Information::with(['ppk', 'unit', 'answers'])
                ->where('ticket_id', '=', $ticket_id)
                ->firstOrFail();

            if (($data->status === 1 && $data->target === null) || ($data->status === 6 && $data->is_finish == false)) {
                $step = 2;
            } elseif ($data->status === 1 && $data->target !== null) {
                $step = 3;
            } elseif ($data->status === 9 && $data->is_finish == false) {
                $step = 3;
            } elseif (($data->status === 6 || $data->status === 9) && $data->is_finish == true) {
                $step = 4;
            }
        }
        return view('tracing-result')->with(['data' => $data, 'step' => $step, 'type' => $type]);
    }
}
