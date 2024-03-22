<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkAchivementGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_achivement_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_kelas_id');
            $table->unsignedBigInteger('tk_point_id');
            $table->unsignedBigInteger('term_id');
            $table->enum('achivement', ['C', 'ME', 'I', 'NI']);
            $table->timestamps();

            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
            $table->foreign('tk_point_id')->references('id')->on('tk_points')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_achivement_grades');
    }
}
