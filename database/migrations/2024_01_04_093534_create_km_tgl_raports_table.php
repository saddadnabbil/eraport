<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmTglRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('km_tgl_raports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tapel_id')->unique()->unsigned();
            $table->string('tempat_penerbitan', 50);
            $table->date('tanggal_pembagian');
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
        Schema::dropIfExists('km_tgl_raports');
    }
}
