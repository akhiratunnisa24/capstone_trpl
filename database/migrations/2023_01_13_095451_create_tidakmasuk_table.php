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
        Schema::create('tidakmasuk', function (Blueprint $table) {
            $table->id();
            
            $table->integer('id_pegawai');
            $table->string('nama')->nullable(); 
            $table->integer('divisi')->nullable();
            $table->string('status')->nullable(); 
            $table->date('tanggal');

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
        Schema::dropIfExists('tidakmasuk');
    }
};
