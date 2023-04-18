<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PembatalanNotification extends Mailable
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
       if($this->data['status'] == "Mengajukan Pembatalan")
       {
            return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan2'], 'Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
                ->view('emails.cutibatal')->with('data',$this->data);   
       }
       elseif($this->data['status'] == "Pembatalan Disetujui Atasan")
       {
            return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
                ->subject($this->data['subject'])
                ->cc($this->data['karyawan_email'], 'Karyawan')
                ->view('emails.cutibatal')->with('data',$this->data);  
       }
       elseif($this->data['status'] == "Pembatalan Disetujui")
       {
            return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan2'], 'Pimpinan Unit Kerja')
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
                ->view('emails.cutibatal')->with('data',$this->data);  
       }
       elseif($this->data['status'] == "Pending Atasan")
       {
            return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc($this->data['atasan2'], 'Pimpinan Unit Kerja')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
                ->view('emails.cutibatal')->with('data',$this->data);  
       }
       else
       {
            return $this->from('raddicacomp2@gmail.com','no-reply@grm.com')
                ->subject($this->data['subject'])
                ->cc($this->data['atasan2'], 'Pimpinan Unit Kerja')
                ->cc($this->data['atasan1'], 'Atasan')
                ->cc('akhiratunnisahasanah0917@gmail.com','HRD GRM')
                ->view('emails.cutibatal')->with('data',$this->data); 
       }
      

            // ->cc('hrd-global@grm-risk.com','HRD GRM')
            // ->cc('pandu@grm-risk.com','HRD Staff')
            // ->cc('ariswan@grm-risk.com','HRD Manager')
    }

}
