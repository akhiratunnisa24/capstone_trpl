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
        Schema::create('cuti_ubah', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_permohonan')->nullable()->default(null);
            $table->string('nik',20);
            $table->unsignedBigInteger('id_karyawan');
            $table->string('jabatan',100);
            $table->integer('departemen');
            $table->unsignedBigInteger('id_jeniscuti');
            $table->unsignedBigInteger('id_alokasi');
            $table->unsignedBigInteger('id_settingalokasi');
            $table->text('keperluan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('jmlharikerja');
            $table->integer('saldohakcuti');
            $table->integer('jml_cuti');
            $table->integer('sisacuti');
            $table->string('keterangan',100);
            $table->string('status');
            $table->string('catatan',50)->nullable()->default(null);
            $table->datetime('tgldisetujui_a')->nullable()->default(null);
            $table->datetime('tgldisetujui_b')->nullable()->default(null);
            $table->datetime('tglditolak')->nullable()->default(null);
            $table->datetime('batal_atasan')->nullable()->default(null);
            $table->datetime('batal_pimpinan')->nullable()->default(null);
            $table->datetime('batalditolak')->nullable()->default(null);
            $table->datetime('ubah_atasan')->nullable()->default(null);
            $table->datetime('ubah_pimpinan')->nullable()->default(null);
            $table->datetime('ubahditolak')->nullable()->default(null);
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
        Schema::dropIfExists('cuti_ubah');
    }
};
