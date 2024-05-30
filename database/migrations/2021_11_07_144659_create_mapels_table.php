<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tapel_id')->unsigned();
            $table->string('nama_mapel');
            $table->string('nama_mapel_indonesian');
            $table->string('ringkasan_mapel', 50);
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tapel_id')->references('id')->on('tapels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapel');
    }
}
