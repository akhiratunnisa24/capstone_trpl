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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai');
            $table->string('hubungan')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('nama');            
            $table->date('tgllahir');
            $table->text('alamat');
            $table->string('pendidikan_terakhir');
            $table->text('pekerjaan');

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
        Schema::dropIfExists('keluarga');
    }
};
