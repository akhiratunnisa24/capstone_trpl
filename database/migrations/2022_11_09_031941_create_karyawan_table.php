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
            $table->string('tempatlahir')->nullable();           
            $table->string('email')->unique();         
            $table->string('agama')->nullable(); 
            $table->enum('gol_darah',['A','B','AB','O'])->nullable();   
            $table->enum('jenis_kelamin',['Laki-Laki','Perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->text('no_hp')->nullable();
            $table->enum('status_karyawan',['Tetap','Kontrak','Probation'])->nullable();
            $table->enum('tipe_karyawan',['Fulltime','Freelance','Magang'])->nullable();
            $table->string('atasan_pertama',50)->nullable();
            $table->string('atasan_kedua',50)->nullable();

            $table->integer('no_kk')->nullable();
            $table->enum('status_kerja',['Aktif','Non-Aktif'])->nullable();
            $table->integer('cuti_tahunan')->nullable();
            $table->integer('divisi')->nullable();
            $table->string('no_rek', 20)->nullable();
            $table->string('no_bpjs_kes', 20)->nullable();
            $table->string('no_npwp', 20)->nullable();
            $table->string('no_bpjs_ket', 20)->nullable();
            $table->string('no_akdhk', 20)->nullable();
            $table->string('no_program_pensiun', 20)->nullable();
            $table->string('no_program_askes', 20)->nullable();
            $table->string('nama_bank')->nullable(); 
            $table->string('kontrak')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('gaji')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->integer('jumlah_anak')->nullable();

            $table->date('tglmasuk')->nullable();
            $table->date('tglkeluar')->nullable();
            $table->string('foto')->nullable();

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
