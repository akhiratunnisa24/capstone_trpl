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
        Schema::create('penggajian_grup', function (Blueprint $table) {
            $table->id();
            $table->string('nama_grup');
            $table->integer('id_struktur');
            $table->date('tglawal');
            $table->date('tglakhir');
            $table->date('tglgajian');
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
        Schema::dropIfExists('penggajian_grup');
    }
};
