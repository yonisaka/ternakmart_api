<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('transaksi', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('id_ternak');
        //     $table->foreign('user_id')->references('id')->on('ternak');
        //     $table->unsignedBigInteger('id_user');
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->integer('ternak_harga');
        //     $table->integer('masa_perawatan');
        //     $table->integer('total_harga');
        //     $table->date('transaksi_tanggal');
        //     $table->string("transaksi_st");
        //     $table->text('transaksi_alamat');
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
