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
        Schema::create('benefit_karyawan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_struktur_gaji');
            $table->integer('id_detailstrukturgaji');
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
        Schema::dropIfExists('benefit_karyawan');
    }
};
