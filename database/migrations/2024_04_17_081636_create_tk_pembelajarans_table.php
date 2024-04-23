<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkPembelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tk_topic_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('tingkatan_id');
            $table->unsignedBigInteger('guru_id')->nullable();

            $table->timestamps();

            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('tk_topic_id')->references('id')->on('tk_topics')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('tingkatan_id')->references('id')->on('tingkatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_set_teachers');
    }
}
