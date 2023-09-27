<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CutiNotification extends Mailable
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
        $hrdmanager = $this->data['hrdmanager'] ?? null;
        $hrdstaff = $this->data['hrdstaff'] ?? null;

        return $this->from('no-reply@rynest.com')
            ->subject($this->data['subject'])
            ->cc($this->data['karyawan_email'], 'Karyawan')
            ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '','Pimpinan Unit Kerja')
            ->cc($hrdmanager,'HRD Manager')
            ->cc($hrdstaff,'HRD Staff')
            ->view('emails.cutiindex')->with('data',$this->data);   

            // ->cc('hrd-global@grm-risk.com','HRD GRM')
            // ->cc('pandu@grm-risk.com','HRD Staff')
            // ->cc('ariswan@grm-risk.com','HRD Manager')
    }
}
