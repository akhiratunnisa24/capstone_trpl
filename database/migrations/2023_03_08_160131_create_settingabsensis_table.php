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
        Schema::create('setting_absensi', function (Blueprint $table) {
            $table->id();
            $table->time('toleransi_terlambat')->nullable();
            $table->integer('jumlah_terlambat')->nullable();
            $table->enum('sanksi_terlambat',['Teguran Biasa','SP Pertama','SP Kedua','SP Ketiga'])->nullable();
            $table->integer('jumlah_tidakmasuk')->nullable();
            $table->string('status_tidakmasuk,20')->nullable();
            $table->enum('sanksi_tidak_masuk',['Potong Gaji','Potong Cuti Tahunan'])->nullable();
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
        Schema::dropIfExists('setting_absensi');
    }
};
