<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use App\Models\Lowongan;

class RekruitmenDiterimaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];
    public $lowongan = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

        // query untuk mengambil data posisi dari tabel lowongan
        $lowongan = Lowongan::find($this->data['id_lowongan']);
        if (!$lowongan) {
            throw new \Exception("Lowongan dengan ID {$this->data['lowongan_id']} tidak ditemukan.");
        }

        $this->lowongan = $lowongan;
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
            ->from('no-reply@rynest.com')
            ->subject('Pemberitahuan Penerimaan di Perusahaan Global Risk Management')
            ->view('emails.RekruitmenDiterimaNotif')
            ->with('data', $this->data)
            ->with('posisi', $this->lowongan);
    }
}
