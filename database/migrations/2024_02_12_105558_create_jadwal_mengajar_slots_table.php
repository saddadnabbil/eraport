<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalMengajarSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_mengajar_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_mengajar_id')->unsigned();

            $table->time('start_time');
            $table->time('stop_time');
            $table->enum('keterangan', ['1', '2', '3']);

            $table->timestamps();

            $table->foreign('jadwal_mengajar_id')->references('id')->on('jadwal_mengajars')->onDelete('cascade');

            // keterangan
            // 1 = jam mengajar
            // 2 = recess
            // 3 = mealtime
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
