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
            $table->time('jadwal_pulang')->nullable()->default(null);
            $table->time('jam_masuk')->nullable()->default(null);
            $table->time('jam_keluar')->nullable()->default(null);
            $table->double('normal',5,3);
            $table->double('riil',5,3);
            $table->time('terlambat')->nullable()->default(null);
            $table->time('plg_cepat')->nullable()->default(null);
            $table->string('absent',5)->nullable();
            $table->time('lembur')->nullable()->default(null);;
            $table->time('jml_jamkerja')->nullable()->default(null);
            $table->string('pengecualian')->nullable()->default(null);
            $table->string('hci',5);
            $table->string('hco',5);
            $table->double('h_normal',5,3);
            $table->double('ap',5,3);
            $table->double('hl',5,3);
            $table->time('jam_kerja')->nullable()->default(null);
            $table->double('lemhanor',5,3);
            $table->double('lemakpek',5,3);
            $table->double('lemhali',5,3);
           
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
