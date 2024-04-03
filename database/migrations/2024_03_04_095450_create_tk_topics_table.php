<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tk_element_id');
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('tk_element_id')->references('id')->on('tk_elements')->onDelete('cascade');
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
        Schema::dropIfExists('tk_topics');
    }
}
