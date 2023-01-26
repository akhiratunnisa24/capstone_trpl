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
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_jeniscuti');
            $table->unsignedBigInteger('id_alokasi');
            $table->unsignedBigInteger('id_settingalokasi');
            $table->text('keperluan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('jml_cuti');
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
