<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataDokter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('nomor_hp');
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
        Schema::dropIfExists('dokter');
    }
}
