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
        Schema::create('timkaryawan', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_tim');
            $table->Integer('divisi');
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
        Schema::dropIfExists('timkaryawan');
    }
};
