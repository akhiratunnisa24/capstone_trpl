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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('no_id');
            $table->unsignedBigInteger('id_karyawan');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->time('scan_masuk')->nullable();
            $table->time('scan_keluar')->nullable();
            $table->time('terlambat')->nullable();
            $table->time('plg_cepat')->nullable();
            $table->time('lembur')->nullable();
            $table->time('jam_kerja')->nullable();
            $table->integer('jml_hadir')->nullable();
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
};
