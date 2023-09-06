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
        Schema::create('detail_penggajian', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_penggajian');
            $table->integer('id_benefit');
            $table->integer('id_detailinformasigaji');
            $table->decimal('nominal',10,2);
            $table->decimal('jumlah',10,2);
            $table->decimal('total',10,2);
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
        Schema::dropIfExists('detail_penggajian');
    }
};
