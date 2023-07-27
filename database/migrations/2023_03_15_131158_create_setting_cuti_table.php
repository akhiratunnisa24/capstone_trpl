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
        Schema::create('setting_cuti', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pegawai');
            $table->integer('id_jeniscuti');
            $table->integer('id_alokasi');
            $table->integer('jumlah_cuti');
            $table->integer('sisa_cuti')->nullable();
            $table->year('periode');
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
        Schema::dropIfExists('setting_cuti');
    }
};
