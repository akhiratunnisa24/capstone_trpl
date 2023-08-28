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
        Schema::create('informasi_gaji', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_strukturgaji');
            $table->string('status_karyawan');
            $table->integer('level_jabatan');
            $table->decimal('gaji_pokok',10,2);
            $table->integer('partner');
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
        Schema::dropIfExists('informasi_gaji');
    }
};
