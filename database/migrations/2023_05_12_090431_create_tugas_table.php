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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tim_id')->nullable();
            $table->unsignedBigInteger('id_karyawan');
            $table->integer('nik');
            $table->string('judul');
            $table->text('deskripsi');
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_deadline');
            $table->enum('status', ['Belum Selesai', 'Dalam Proses', 'Sudah Selesai']);
            $table->text('komentar')->nullable();
            $table->boolean('keterangan');
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
        Schema::dropIfExists('tugas');
    }
};
