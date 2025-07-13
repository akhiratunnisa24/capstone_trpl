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
        Schema::create('prediction_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->string('nama');
            $table->string('status_karyawan')->nullable();
            $table->string('status_kerja')->nullable();
            $table->float('rasio_keterlambatan')->nullable();
            $table->float('rasio_pulang_cepat')->nullable();
            $table->integer('total_hari_izin')->default(0);
            $table->integer('total_hari_sakit')->default(0);
            $table->integer('jumlah_cuti')->default(0);
            $table->float('resign_probability');
            $table->float('risk_score');
            $table->string('prediksi_resign');
            $table->integer('prediction_number')->default(1);
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
        Schema::dropIfExists('prediction_histories');
    }
};
