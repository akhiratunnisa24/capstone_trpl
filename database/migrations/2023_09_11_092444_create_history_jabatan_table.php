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
        Schema::create('history_jabatan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_jabatan');
            $table->integer('id_leveljabatan');
            $table->decimal('gaji_terakhir',10,2);
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
        Schema::dropIfExists('history_jabatan');
    }
};
