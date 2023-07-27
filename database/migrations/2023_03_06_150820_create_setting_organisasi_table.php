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
        Schema::create('setting_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('email'); 
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('kode_pos');
            $table->string('logo');
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
        Schema::dropIfExists('setting_organisasi');
    }
};
