<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tingkatan_id')->unsigned();
            $table->unsignedBigInteger('jurusan_id')->unsigned();
            $table->unsignedBigInteger('tapel_id')->unsigned();
            $table->unsignedBigInteger('guru_id')->unsigned();
            $table->string('nama_kelas', 30);
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('tingkatan_id')->references('id')->on('tingkatans')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');;
            $table->foreign('tapel_id')->references('id')->on('tapels')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}
