<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Lowongan;

class RekruitmenApplyNotification extends Mailable
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

    public function build()
    {

        return $this
            ->from( 'no-reply@grm.com')
            ->subject('Pemberitahuan Apply Rekruitmen GRM')
            ->view('emails.RekruitmenApplyNotif')
            ->with('data', $this->data)
            ->with('posisi', $this->lowongan);

    }
    
}
