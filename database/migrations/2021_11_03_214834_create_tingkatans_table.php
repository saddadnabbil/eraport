<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTingkatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tingkatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tingkatan', 50);
            $table->unsignedBigInteger('term_id')->unsigned();
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tingkatans');
    }
}
