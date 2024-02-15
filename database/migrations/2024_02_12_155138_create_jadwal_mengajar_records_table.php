<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalMengajarRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_mengajar_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_mengajar_slot_id')->unsigned()->nullable();
            $table->unsignedBigInteger('kelas_id')->unsigned()->nullable();
            $table->string('hari');
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('jadwal_mengajar_slot_id')->references('id')->on('jadwal_mengajar_slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_pelajaran_record');
    }
}
