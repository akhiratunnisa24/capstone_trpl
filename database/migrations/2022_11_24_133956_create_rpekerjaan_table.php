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
        Schema::create('_rpekerjaan', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai');
            $table->string('nama_perusahaan')->nullable();
            $table->string('alamat');            
            $table->string('jenis_usaha');
            $table->string('jabatan');
            $table->text('nama_atasan');
            $table->text('nama_direktur');
            $table->text('lama_kerja');
            $table->text('alasan_berhenti');
            $table->text('gaji');


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
        Schema::dropIfExists('_rpekerjaan');
    }
};
