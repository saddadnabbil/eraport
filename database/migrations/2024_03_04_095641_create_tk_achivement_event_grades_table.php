<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkAchivementEventGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_achivement_event_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_kelas_id');
            $table->unsignedBigInteger('tk_event_id');
            $table->enum('grade', ['C', 'ME', 'I', 'NI']);
            $table->timestamps();

            $table->foreign('tk_event_id')->references('id')->on('tk_events')->onDelete('cascade');
            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_achivement_event_grades');
    }
}
