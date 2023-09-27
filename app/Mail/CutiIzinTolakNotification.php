<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CutiIzinTolakNotification extends Mailable
{
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
            ->cc($this->data['atasan1'], 'Atasan Karyawan')
            ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '', 'Pimpinan')
            ->cc($hrdmanager,'HRD Manager')
            ->cc($hrdstaff,'HRD Staff')
            // ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
            ->view('emails.tolakindex')->with('data',$this->data);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
