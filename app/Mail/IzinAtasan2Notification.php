<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IzinAtasan2Notification extends Mailable
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
        return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
        ->subject($this->data['subject'])
        ->cc($this->data['karyawan_email'], 'Karyawan')
        ->cc($this->data['atasan1'], 'Atasan Pertama')
        ->cc('akhiratunnisahasanah0917@gmail.com','HRD')
        ->view('emails.izin2index')->with('data',$this->data);
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
