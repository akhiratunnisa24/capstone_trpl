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
        Schema::create('namatahapan', function (Blueprint $table) {
            $table->id();

            $table->integer('id_lowongan')->nullable();
            $table->integer('id_mrekruitmen')->nullable();
            $table->integer('urutan')->nullable();

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
        Schema::dropIfExists('namatahapan');
    }
};
