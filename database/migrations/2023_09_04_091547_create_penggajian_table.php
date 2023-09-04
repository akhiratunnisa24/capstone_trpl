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
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->date('tglawal');
            $table->date('tglakhir');
            $table->date('tglgajian');
            $table->decimal('gaji_pokok',2);
            $table->decimal('lembur',2)->nullable->default(null);
            $table->decimal('tunjangan',2)->nullable->default(null);
            $table->decimal('gaji_kotor',2);
            $table->decimal('asuransi',2)->nullable->default(null);
            $table->decimal('potongan',2)->nullable->default(null);
            $table->decimal('pajak',2)->nullable->default(null);
            $table->decimal('gaji_bersih',2);
            $table->varchar('nama_bank',50);
            $table->varchar('no_rekening',50);
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
        Schema::dropIfExists('penggajian');
    }
};
