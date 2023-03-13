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
        Schema::create('rprestasi', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai');
            $table->string('keterangan')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('no_surat')->nullable();

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
        Schema::dropIfExists('rprestasis');
    }
};
