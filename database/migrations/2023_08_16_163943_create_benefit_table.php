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
        Schema::create('benefit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_benefit');
            $table->integer('id_kategori');
            $table->string('kode');
            $table->string('aktif');
            $table->string('dikenakan_pajak');
            $table->string('kelas_pajak');
            $table->string('tipe');
            $table->boolean('muncul_dipenggajian');
            $table->string('siklus_pembayaran');
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
        Schema::dropIfExists('benefit');
    }
};
