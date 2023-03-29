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
        Schema::create('kdarurat', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai')->nullable();
            $table->integer('id_pelamar')->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();          
            $table->string('no_hp')->nullable();
            $table->string('hubungan')->nullable();


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
        Schema::dropIfExists('kdarurat');
    }
};
