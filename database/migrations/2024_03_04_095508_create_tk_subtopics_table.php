<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkSubtopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_subtopics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tk_topic_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('tk_topic_id')->references('id')->on('tk_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_subtopics');
    }
}
