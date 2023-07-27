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
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            
            $table->integer('id_pegawai');

            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bpjs_ket')->nullable();
            $table->string('bpjs_kes')->nullable();
            $table->string('as_akdhk')->nullable();
            $table->string('buku_tabungan')->nullable();
            $table->string('skck')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('lamaran')->nullable();
            $table->string('surat_pengalaman_kerja')->nullable();
            $table->string('surat_penghargaan')->nullable();
            $table->string('surat_pelatihan')->nullable();
            $table->string('surat_perjanjian_kerja')->nullable();
            $table->string('surat_pengangkatan_kartap')->nullable();
            $table->string('surat_alih_tugas')->nullable();

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
        Schema::dropIfExists('files');
    }
};
