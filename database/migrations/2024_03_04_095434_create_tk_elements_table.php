<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tingkatan_id');
            $table->string('name');
            $table->timestamps();

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
        Schema::dropIfExists('tk_elements');
    }
}
