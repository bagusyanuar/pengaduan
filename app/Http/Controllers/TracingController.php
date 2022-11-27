<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Complain;

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
        if ($type === 'complain') {
            $data = Complain::with(['ppk', 'unit', 'answers'])
                ->where('ticket_id', '=', $ticket_id)
                ->firstOrFail();
        }
        return view('tracing-result')->with(['data' => $data]);
    }
}
