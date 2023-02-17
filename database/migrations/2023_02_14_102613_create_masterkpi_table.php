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
        Schema::create('masterkpi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_departemen');
            $table->string('nama_master');
            $table->string('bobot',10);
            $table->string('target',10);
            $table->date('tglaktif');
            $table->date('tglberakhir');
            $table->Integer('status');
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
        Schema::dropIfExists('masterkpi');
    }
};
