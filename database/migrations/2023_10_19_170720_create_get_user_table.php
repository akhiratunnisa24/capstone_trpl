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
        Schema::create('get_user', function (Blueprint $table) {
            $table->id();
            $table->string('PIN');
            $table->string('Name');
            $table->string('Password')->nullable()->change();
            $table->string('Group')->nullable();
            $table->string('Privilege')->nullable();
            $table->string('Card');
            $table->integer('status');
            $table->string('partner');
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
        Schema::dropIfExists('get_user');
    }
};
