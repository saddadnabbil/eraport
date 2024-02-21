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
            $table->unsignedBigInteger('jadwal_pelajaran_slot_id')->unsigned()->nullable();
            $table->unsignedBigInteger('kelas_id')->unsigned()->nullable();
            $table->unsignedBigInteger('guru_id')->unsigned()->nullable();
            $table->unsignedBigInteger('mapel_id')->unsigned()->nullable();
            $table->string('hari');
            $table->timestamps();

            $table->foreign('jadwal_pelajaran_slot_id')->references('id')->on('jadwal_pelajaran_slots')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
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
