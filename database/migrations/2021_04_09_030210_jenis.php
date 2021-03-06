<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jenis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_golongan');
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->string('jenis_nama');
            $table->enum('jenis_kelamin', ['J', 'B']);
            $table->integer('perawatan_harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jenis');
    }
}
