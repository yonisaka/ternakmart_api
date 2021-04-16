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
        // Schema::create('ternak', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('ternak_nama', 200);
        //     $table->integer('ternak_berat');
        //     $table->integer('ternak_tinggi');
        //     $table->integer('ternak_umur');
        //     $table->text('ternak_deskripsi');
        //     $table->unsignedBigInteger('id_pedagang');
        //     $table->unsignedBigInteger('id_verifikator');
        //     $table->integer('ternak_harga');
        //     $table->date('tgl_penerimaan');
        //     $table->string('ternak_st', 200);
        //     $table->string('verifikasi_st', 200);
        //     $table->foreignId('id_jenis');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
