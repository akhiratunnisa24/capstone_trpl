<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriSalaryController extends Controller
{
    public function index()
    {
        return view('admin.datamaster.salary.kategori.index');
    }

    // public function store(Request $request)
    // {
    //     // Simpan data kategori ke dalam tabel kategori_salary
    //     $kategori = new KategoriSalary();
    //     $kategori->nama = $request->nama_kategori;
    //     $kategori->partner = $request->partner; // Ambil dari input hidden
    //     // ... isikan kolom lainnya sesuai kebutuhan
    //     $kategori->save();

    //     return redirect()->back()->with('success', 'Kategori salary berhasil ditambahkan.');
    // }

}
