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
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_permohonan')->nullable()->default(null);
            $table->string('nik',20);
            $table->string('jabatan',100);
            $table->integer('departemen');
            $table->unsignedBigInteger('id_karyawan');
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
            $table->date('tgldisetujui_a')->nullable()->default(null);
            $table->date('tgldisetujui_b')->nullable()->default(null);
            $table->date('tglditolak')->nullable()->default(null);
            $table->string('status')->default('Pending');

            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
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
        Schema::dropIfExists('cuti');
    }
};
