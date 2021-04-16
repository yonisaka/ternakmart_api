<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ternak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ternak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ternak_nama', 200);
            $table->unsignedBigInteger('id_jenis');
            $table->foreign('id_jenis')->references('id')->on('jenis');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('ternak_berat');
            $table->integer('ternak_tinggi');
            $table->integer('ternak_umur');
            $table->text('ternak_deskripsi');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id')->on('customer');
            $table->unsignedBigInteger('id_dokter');
            $table->foreign('id_dokter')->references('id')->on('dokter');
            $table->unsignedBigInteger('id_penjual');
            $table->foreign('id_penjual')->references('id')->on('penjual');
            $table->integer('ternak_harga');
            $table->date('tgl_penerimaan');
            $table->date('tgl_keluar');
            $table->enum('ternak_st', ['1', '0'])->default('0');
            $table->enum('verifikasi_st', ['1', '0'])->default('0');
            $table->text('verifikasi_note');
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
        Schema::dropIfExists('ternak');
    }
}
