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
        Schema::create('kpi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_job');
            $table->unsignedBigInteger('id_user');
            $table->text('indikator');
            $table->string('target');
            $table->string('bobot');
            $table->date('tglaktif');
            $table->date('tglberakhir');
            $table->string('status');
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
        Schema::dropIfExists('kpi');
    }
};
