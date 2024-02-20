<?php

namespace App\Mail;

use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SlipgajiNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data=[];
    public $datapdf = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$datapdf)
    {
        $this->data = $data;
        $this->datapdf = $datapdf;
    }

    public function build()
    {
        // $pdf = PDF::loadView('admin.penggajian.slipgajipdf', $this->datapdf);
        $pdf = app('dompdf.wrapper')->loadView('admin.penggajian.slipgajipdf', $this->datapdf);
        $pdf->setEncryption($this->datapdf['password']);
        $pdfFileName = 'Slip Gaji '. $this->data['periode'] . " " . $this->data['nama']. ".pdf";
        return $this->from('no-reply@rynest-technology.com')
            ->subject($this->data['subject'])
            ->view('emails.gajiindex')->with('data',$this->data)
            ->attachData($pdf->output(), $pdfFileName, [
                'mime' => 'application/pdf',
            ]);
    }
}
