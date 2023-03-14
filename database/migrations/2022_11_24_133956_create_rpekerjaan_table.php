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
        Schema::create('rpekerjaan', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai');
            $table->string('nama_perusahaan')->nullable();
            $table->string('alamat')->nullable();            
            $table->string('jenis_usaha')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('level')->nullable();
            $table->text('nama_atasan')->nullable();
            $table->text('nama_direktur')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('alasan_berhenti')->nullable();
            $table->text('gaji')->nullable();


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
        Schema::dropIfExists('rpekerjaan');
    }
};
