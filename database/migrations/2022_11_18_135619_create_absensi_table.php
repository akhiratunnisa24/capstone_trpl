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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->string('nik')->nullable()->default(null);
            $table->date('tanggal');
            $table->string('shift');
            $table->time('jadwal_masuk');
            $table->time('jadwal_pulang');
            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable()->default(null);
            $table->double('normal',2,1);
            $table->double('riil',2,1);
            $table->time('terlambat')->nullable()->default(null);
            $table->time('plg_cepat')->nullable()->default(null);
            $table->string('absent',5);
            $table->time('lembur')->nullable()->default(null);;
            $table->time('jml_jamkerja')->nullable()->default(null);
            $table->string('pengecualian')->nullable()->default(null);
            $table->string('hci',5)->default(True);
            $table->string('hco',5)->default(True);
            $table->string('id_departemen');
            $table->double('h_normal',2,1);
            $table->double('ap',2,1);
            $table->double('hl',2,1);
            $table->time('jam_kerja')->nullable()->default(null);
            $table->double('lemhanor',2,1);
            $table->double('lemakpek',2,1);
            $table->double('lemhali',2,1);
           
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
           
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
        Schema::dropIfExists('absensi');
    }
};
