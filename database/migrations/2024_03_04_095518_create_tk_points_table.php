<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tk_topic_id');
            $table->unsignedBigInteger('tk_subtopic_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('tk_subtopic_id')->references('id')->on('tk_subtopics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_points');
    }
}
