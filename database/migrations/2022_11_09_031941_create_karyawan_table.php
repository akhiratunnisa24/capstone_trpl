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

            $table->integer('nip')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->date('tgllahir')->nullable();           
            $table->string('email')->unique();         
            $table->string('agama')->nullable(); 
            $table->enum('gol_darah',['A','B','AB','O'])->nullable();   
            $table->enum('jenis_kelamin',['L','P']);
            $table->text('alamat')->nullable();
            $table->text('no_hp')->nullable();
            $table->enum('status_karyawan',['Tetap','Kontrak','Probation'])->nullable();
            $table->enum('tipe_karyawan',['Fulltime','Freelance','Magang'])->nullable();
            $table->string('manager')->nullable();

            $table->integer('no_kk')->nullable();
            $table->enum('status_kerja',['Aktif','Non-Aktif'])->nullable();
            $table->integer('cuti_tahunan')->nullable();
            $table->integer('divisi')->nullable();
            $table->integer('no_rek')->nullable();
            $table->integer('no_bpjs_kes')->nullable();
            $table->integer('no_npwp')->nullable();
            $table->integer('no_bpjs_ket')->nullable();
            $table->string('kontrak')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('gaji')->nullable();


            $table->date('tglmasuk')->nullable();
            $table->date('tglkeluar')->nullable();

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
