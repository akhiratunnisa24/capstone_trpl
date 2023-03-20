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
        Schema::create('settingalokasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jeniscuti');
            $table->integer('durasi');
            $table->string('mode_karyawan',100)->nullable();
            $table->string('cuti_bersama_terhutang',10)->nullable();
            $table->timestamps();

            $table->foreign('id_jeniscuti')->references('id')->on('jeniscuti')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settingalokasi');
    }
};
