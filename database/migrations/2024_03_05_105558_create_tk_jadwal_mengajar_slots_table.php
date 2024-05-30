<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkJadwalMengajarSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_jadwal_mengajar_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tapel_id')->unsigned();

            $table->time('start_time');
            $table->time('stop_time');
            $table->enum('keterangan', ['1', '2', '3']);

            $table->timestamps();

            $table->foreign('tapel_id')->references('id')->on('tapels')->onDelete('cascade');

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
