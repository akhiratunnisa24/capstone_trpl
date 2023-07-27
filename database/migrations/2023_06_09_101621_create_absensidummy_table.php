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
        Schema::create('absensidummy', function (Blueprint $table) {
            $table->id();
            $table->integer('noid');
            $table->string('nama');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->time('scan_masuk');
            $table->time('scan_keluar');
            $table->time('terlambat');
            $table->time('plg_cepat');
            $table->time('lembur');
            $table->time('jam_kerja');
            $table->time('jml_hadir');
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
        Schema::dropIfExists('absensidummy');
    }
};
