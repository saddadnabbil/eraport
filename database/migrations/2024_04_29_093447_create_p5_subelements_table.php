<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP5SubelementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p5_subelements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p5_element_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('p5_element_id')->references('id')->on('p5_elements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p5_subelements');
    }
}
