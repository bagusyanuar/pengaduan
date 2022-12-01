<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyInformation extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $attach;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param string $attach
     */
    public function __construct($data, $attach = '')
    {
        $this->data = $data;
        $this->attach = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $answer = $this->data->approved_answer;
        return $this->view('mails.reply-information')
            ->attach($this->attach, [
                'as' => 'Surat Pengantar.pdf',
                'mime' => 'application/pdf'
            ])
            ->attach(substr($answer->file, 1), [
                'as' => 'Jawaban.pdf',
                'mime' => 'application/pdf'
            ])
            ->subject('Balasan Permintaan Informasi (' . $this->data->ticket_id . ')');
    }
}
