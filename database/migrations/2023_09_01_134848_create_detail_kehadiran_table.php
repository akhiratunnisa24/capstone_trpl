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
        Schema::create('detail_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
            $table->integer('jumlah_lembur')->nullable()->default(null);
            $table->integer('jumlah_cuti')->nullable()->default(null);
            $table->integer('jumlah_izin')->nullable()->default(null);
            $table->integer('partner');
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
        Schema::dropIfExists('detail_kehadiran');
    }
};
