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

            $table->integer('id_pegawai');
            $table->enum('tingkat',['SD','SMP','SMA/K','Universitas'])->nullable();

            $table->string('nama_sekolah');            
            $table->string('kota_pformal');
            $table->string('kota_pnonformal');
            $table->string('jurusan');
            $table->text('tahun_lulus_formal');
            $table->text('tahun_lulus_nonformal');
            $table->text('jenis_pendidikan');


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
