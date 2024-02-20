<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PerubahanNotification extends Mailable
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
       if($this->data['status'] == "Mengajukan Perubahan")
       {
            return $this->from('no-reply@rynest-technology.com')
                ->subject($this->data['subject'])
                ->cc($this->data['karyawan_email'], 'Karyawan')
                ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '','Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD')
                ->view('emails.cutibatal')->with('data',$this->data);
       }
       elseif($this->data['status'] == "Perubahan Disetujui Atasan")
       {
            return $this->from('no-reply@rynest-technology.com')
                ->subject($this->data['subject'])
                ->cc($this->data['karyawan_email'], 'Karyawan')
                ->view('emails.cutibatal')->with('data',$this->data);
       }
       elseif($this->data['status'] == "Perubahan Disetujui")
       {
            return $this->from('no-reply@rynest-technology.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '','Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD')
                ->view('emails.cutibatal')->with('data',$this->data);
       }
       elseif($this->data['status'] == "Pending Atasan")
       {
            return $this->from('no-reply@rynest-technology.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '','Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD')
                ->view('emails.cutibatal')->with('data',$this->data);
       }
       else
       {
            return $this->from('no-reply@rynest-technology.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc(isset($this->data['atasan2']) ? $this->data['atasan2'] : '','Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD')
                ->view('emails.cutibatal')->with('data',$this->data);
       }
    }

}
