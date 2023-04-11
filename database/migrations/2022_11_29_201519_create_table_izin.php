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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_permohonan')->nullable()->default(null);
            $table->string('nik');
            $table->unsignedBigInteger('id_karyawan');
            $table->string('jabatan');
            $table->integer('departemen');
            $table->unsignedBigInteger('id_jenisizin');
            $table->text('keperluan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable()->default(null);
            $table->time('jam_mulai')->nullable()->default(null);
            $table->time('jam_selesai')->nullable()->default(null);
            $table->date('tgl_setuju_a')->nullable()->default(null);
            $table->date('tgl_setuju_b')->nullable()->default(null);
            $table->date('tgl_ditolak')->nullable()->default(null);
            $table->integer('jml_hari')->nullable()->default('0');
            $table->time('jml_jam')->nullable()->default(null);
            $table->string('status');
    
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('id_jenisizin')->references('id')->on('jenisizin')->onDelete('cascade');
    
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
        Schema::dropIfExists('izin');
    }
};
