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
        Schema::create('kdarurat', function (Blueprint $table) {
            $table->id();

            $table->integer('id_pegawai');
            $table->string('nama')->nullable();
            $table->string('alamat');            
            $table->string('no_hp');
            $table->string('hubungan');


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
        Schema::dropIfExists('kdarurat');
    }
};
