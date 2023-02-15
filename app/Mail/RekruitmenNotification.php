<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;


class RekruitmenNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from('raddicacomp2@gmail.com', 'no-reply@grm.com')
        // ->subject($this->data['subject'])
        // ->view('emails.cutiindex')->with('data', $this->data);

        return $this
        ->from('yasoyahyaa@gmail.com', 'no-reply@grm.com')
        ->subject('Pemberitahuan Hasil Rekruitmen Rynest TI')
        ->view('emails.RekruitmenNotif')->with('data', $this->data);
    }

    
}
