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
        Schema::create('rekruitmen', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai');
            $table->string('posisi')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->date('tgllahir')->nullable();
            $table->string('email')->unique();
            $table->string('agama')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->text('no_hp')->nullable();
            $table->integer('no_kk')->nullable();
            $table->string('gaji')->nullable();

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
        Schema::dropIfExists('rekruitmen');
    }
};
