<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformationDisposition extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $target;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $target
     */
    public function __construct($data, $target)
    {
        $this->data = $data;
        $this->target = $target;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.disposition-information')->subject('Disposisi Permintaan Informasi Baru (' . $this->data->ticket_id . ')');
    }
}
