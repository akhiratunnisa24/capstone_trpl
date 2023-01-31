<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekruitmen;
use App\Mail\RekruitmenNotification;
use Illuminate\Support\Facades\Mail;

class NotifMailRekruitmenController extends Controller
{
    public function index($id)
    {
        $karyawan = Rekruitmen::findOrFail($id);
        // $email = new RekruitmenNotification();
        // Mail::to('ahmadyahya2597@gmail.com')->send($email);

        return view('karyawan.showKaryawan')->with([
            'karyawan' => $karyawan,
        ]);
    }
}
