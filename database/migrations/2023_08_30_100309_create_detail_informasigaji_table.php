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
        Schema::create('detail_informasigaji', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_informasigaji');
            $table->integer('id_struktur');
            $table->integer('id_benefit');
            $table->integer('siklus_bayar');
            $table->decimal('nominal',10,2);
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
        Schema::dropIfExists('detail_informasigaji');
    }
};
