<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IzinNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data=[];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('no-reply@rynest.com')
            ->subject($this->data['subject'])
            ->cc($this->data['karyawan_email'], 'Karyawan')
            ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '', 'Pimpinan')
            ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
            ->view('emails.izinindex')->with('data',$this->data);

              // ->cc('hrd-global@grm-risk.com','HRD GRM')
            // ->cc('pandu@grm-risk.com','HRD Staff')
            // ->cc('ariswan@grm-risk.com','HRD Manager')
    }
}
