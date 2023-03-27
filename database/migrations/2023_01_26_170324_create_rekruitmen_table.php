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

            $table->integer('id_lowongan');
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->date('tgllahir')->nullable();

            $table->string('tempatlahir')->nullable();
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('no_rek', 20)->nullable();
            $table->string('no_bpjs_kes', 20)->nullable();
            $table->string('no_npwp', 20)->nullable();
            $table->string('no_bpjs_ket', 20)->nullable();
            $table->string('no_akdhk', 20)->nullable();
            $table->string('no_program_pensiun', 20)->nullable();
            $table->string('no_program_askes', 20)->nullable();
            $table->string('nama_bank')->nullable(); 

            $table->string('email')->unique();
            $table->string('agama')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->text('no_hp')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('gaji')->nullable();
            $table->string('cv')->nullable();
            $table->string('status_lamaran')->nullable();
            $table->date('tanggal_tahapan')->nullable();


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
