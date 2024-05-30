<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkJadwalMengajarRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_jadwal_mengajar_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tk_jadwal_pelajaran_slot_id')->unsigned()->nullable();
            $table->unsignedBigInteger('kelas_id')->unsigned()->nullable();
            $table->unsignedBigInteger('guru_id')->unsigned()->nullable();
            $table->unsignedBigInteger('tk_topic_id')->unsigned()->nullable();
            $table->string('hari');
            $table->timestamps();

            $table->foreign('tk_jadwal_pelajaran_slot_id')->references('id')->on('tk_jadwal_pelajaran_slots')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('tk_topic_id')->references('id')->on('tk_topics')->onDelete('cascade');
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
