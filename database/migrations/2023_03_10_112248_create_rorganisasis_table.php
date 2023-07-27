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
        Schema::create('rorganisasi', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai')->nullable();
            $table->integer('id_pelamar')->nullable();
            $table->string('nama_organisasi')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('no_sk')->nullable();

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
        Schema::dropIfExists('rorganisasis');
    }
};
