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
        Schema::create('rpendidikan', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai')->nullable();
            $table->integer('id_pelamar')->nullable();
            // $table->enum('tingkat',['SD','SMP','SMA/K','Universitas'])->nullable();
            $table->string('tingkat')->nullable();
            $table->string('nama_sekolah')->nullable();          
            $table->string('nama_lembaga')->nullable();          
            $table->string('kota_pformal')->nullable();
            $table->string('kota_pnonformal')->nullable();
            $table->string('jurusan')->nullable();
            $table->year('tahun_masuk_formal')->nullable();
            $table->year('tahun_lulus_formal')->nullable();
            $table->year('tahun_masuk_nonformal')->nullable();
            $table->year('tahun_lulus_nonformal')->nullable();
            $table->text('jenis_pendidikan')->nullable();
            $table->string('ijazah_formal')->nullable();
            $table->string('ijazah_nonformal')->nullable();


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
        Schema::dropIfExists('rpendidikan');
    }
};
