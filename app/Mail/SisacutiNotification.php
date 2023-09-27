<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SisacutiNotification extends Mailable
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

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        $atasan2 = $this->data['emailatasan2'] ?? null;
        $hrdmanager = $this->data['hrdmanager'] ?? null;
        $hrdstaff = $this->data['hrdstaff'] ?? null;

        return $this->from('no-reply@rynest.com')
            ->subject($this->data['subject'])
            ->cc($this->data['emailatasan1'],'Atasan Pertama')
            ->cc($atasan2,'Atasan Kedua')
            ->cc($hrdmanager,'HRD Manager')
            ->cc($hrdstaff,'HRD Staff')
            ->view('emails.sisacuti')->with('data',$this->data);

        // return $this->from('no-reply@rynest.com')
        // ->subject($this->data['subject'])
        // ->cc($this->data['emailatasan1'],'Atasan Pertama')
        // ->cc($this->data['emailatasan2'],'Atasan Kedua')
        // ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
        //->view('emails.sisacuti')->with('data',$this->data);
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
