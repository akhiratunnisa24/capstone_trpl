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
        Schema::create('alokasicuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_settingalokasi');
            $table->unsignedBigInteger('id_jeniscuti');
            $table->integer('durasi')->nullable();
            $table->enum('status_durasialokasi',['Cuti Tidak Terhutang','Cuti Bersama Terhutang'])->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_sekarang')->nullable();
            $table->date('aktif_dari')->nullable();
            $table->date('sampai')->nullable();
            $table->boolean('status');

            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('id_settingalokasi')->references('id')->on('settingalokasi')->onDelete('cascade');
            $table->foreign('id_jeniscuti')->references('id')->on('jeniscuti')->onDelete('cascade');

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
        Schema::dropIfExists('alokasicuti');
    }
};
