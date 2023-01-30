<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        $data = [
            'subject'=>'Pemberitahuan Permintaan Cuti',
            'body'=>'Anda Memiliki 1 Permintaan Cuti yang harus di Approved',
            'id'=>'1',
            'id_jeniscuti'=>'3',
            'keperluan'=>'cuti tahunan 4 hari',
            'tgl_mulai'=>'17-02-2023',
            'tgl_selesai'=>'21-02-2023',
            'jml_cuti'=>'4',
            'status'=>'Pending',
            'nama'=>'Akhiratunnisa Hasanah',
            'jenis_cuti'=>'Cuti Tahunan',

        ];
        $tujuan = 'andiny700@gmail.com';

        Mail::to($tujuan)->send(new MailNotify($data));
        return 'Email Notifikasi Berhasil Dikirim';

         //testing
        // Mail::to('andiny700@gmail.com')->send(new MailNotify);
        // return 'Email Notifikasi Berhasil Dikirim';
        //   // MailNotify class that is extend from Mailable class.
        //   try
        //   {
            // Mail::to('andiny700@gmail.com')->send(new MailNotify);
            // return 'Email Notifikasi Berhasil Dikirim';
           // return response()->json(['Great! Successfully send in your mail']);
        //   }
        //   catch(Exception $e)
        //   {
        //     return response()->json(['Sorry! Please try again latter']);
        //   }
    }
}
