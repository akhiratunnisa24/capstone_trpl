<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Testmail extends Controller
{
    public function index(Request $request)
    {
        $data = ['message' => 'This is a test!'];

        Mail::to('muktijayaa@gmail.com')->send(new TestEmail($data));
    }
}