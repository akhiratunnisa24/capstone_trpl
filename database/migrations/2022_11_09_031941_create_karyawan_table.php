<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();

            $table->number('nip');

            $table->number('nik');
            
            $table->string('nama');            
            $table->string('tgllahir');            
            $table->string('email')->unique();         
            $table->enum('jenis_kelamin',['L','P']);
            $table->text('alamat');
            $table->text('no_hp');
            $table->enum('status_karyawan',['Tetap','Kontrak','Probation']);
            $table->enum('tipe_karyawan',['Fulltime','Freelance','Magang']);

            $table->number('no_kk');
            $table->enum('status_kerja',['Aktif','Non-Aktif']);
            $table->integer('cuti_tahunan')->nullable();
            $table->string('divisi')->nullable();
            $table->number('no_rek');
            $table->number('no_bpjs_kes');
            $table->number('no_npwp');
            $table->number('no_bpjs_ket');
            $table->string('kontrak');
            $table->string('jabatan');
            $table->string('gaji');


            $table->date('tglmasuk');
            $table->date('tglkeluar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
};
