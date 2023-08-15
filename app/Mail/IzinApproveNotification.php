<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IzinApproveNotification extends Mailable
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
        $email = $this->from('no-reply@rynest.com')
            ->subject($this->data['subject'])
            ->cc($this->data['atasan1'], 'Atasan Pertama')
            ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
            ->view('emails.izinApprove')->with('data',$this->data);
       
        if (isset($this->data['atasan2']) && $this->data['atasan2'] !== null) {
            $email->cc($this->data['atasan2'], 'Atasan Kedua');
        }
        
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
