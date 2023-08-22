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
        Schema::create('benefit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_benefit');
            $table->integer('id_kategori');
            $table->string('kode');
            $table->string('aktif',20);
            $table->string('dikenakan_pajak',20)->nullable()->default(null);
            $table->string('kelas_pajak')->nullable()->default(null);
            $table->string('tipe')->nullable()->default(null);
            $table->decimal('gaji_minimum',10, 2)->nullable()->default(null);
            $table->decimal('gaji_maksimum',10, 2)->nullable()->default(null);
            $table->string('muncul_dipenggajian',10);
            $table->string('siklus_pembayaran');
            $table->integer('urutan');
            $table->decimal('jumlah',10, 2)->nullable()->default(null);
            $table->decimal('besaran_bulanan',10, 2)->nullable()->default(null);
            $table->decimal('besaran_mingguan',10, 2)->nullable()->default(null);
            $table->decimal('besaran_harian',10, 2)->nullable()->default(null);
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
        Schema::dropIfExists('benefit');
    }
};
