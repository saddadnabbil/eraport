<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP5ElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p5_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p5_dimensi_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('p5_dimensi_id')->references('id')->on('p5_dimensis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p5_elements');
    }
}
