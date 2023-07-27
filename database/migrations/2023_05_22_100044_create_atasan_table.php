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
        Schema::create('atasan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_karyawan', false, true); // false untuk non-auto increment
            $table->string('nik', 20);
            $table->string('nama', 255);
            $table->string('level_jabatan', 255);
            $table->string('jabatan', 255);
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
        Schema::dropIfExists('atasan');
    }
};
