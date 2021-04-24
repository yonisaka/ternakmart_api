<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pemeriksaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_ternak');
            $table->foreign('id_ternak')->references('id')->on('ternak');
            $table->unsignedBigInteger('id_dokter');
            $table->foreign('id_dokter')->references('id')->on('dokter');
            $table->integer('rfid');
            $table->enum('vaksin_st', ['1', '0'])->default('0');
            $table->string('obat_cacing');
            $table->smallInteger('umur_bunting');
            $table->date('perkiraan_lahir');
            $table->text('riwayat_kasus');
            $table->smallInteger('temperatur');
            $table->string('tonus_rumen');
            $table->string('inseminasi');
            $table->string('pengobatan');
            $table->date('tgl_pemeriksaan');
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
        Schema::dropIfExists('pemeriksaan');
    }
}
