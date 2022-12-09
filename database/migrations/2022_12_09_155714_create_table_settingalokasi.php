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
            $table->enum('tipe_alokasi',['Reguler','Aktual'])->nullable();
            $table->integer('durasi');
            $table->string('mode_alokasi',50)->nullable();
            $table->string('departemen',50)->nullable();
            $table->string('mode_karyawan',50)->nullable();
            $table->enum('jenis_kelamin',['L','P'])->nullable();
            $table->string('status_pernikahan')->nullable();
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
