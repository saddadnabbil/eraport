<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPelajaranSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_pelajaran_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_pelajaran_id')->unsigned();

            $table->time('start_time');
            $table->time('stop_time');

            $table->timestamps();

            $table->foreign('jadwal_pelajaran_id')->references('id')->on('jadwal_pelajarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_pelajaran_slots');
    }
}
