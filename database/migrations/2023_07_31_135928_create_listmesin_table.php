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
        Schema::create('listmesin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mesin',100);
            $table->string('ip_mesin',30);
            $table->integer('port');
            $table->integer('comm_key');
            $table->integer('partner');
            $table->boolean('status');
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
        Schema::dropIfExists('listmesin');
    }
};
