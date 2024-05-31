<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapaianPembelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capaian_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mapel_id')->nullable()->unsigned();
            $table->unsignedBigInteger('tingkatan_id')->nullable()->unsigned();
            $table->unsignedBigInteger('pembelajaran_id')->unsigned();
            $table->unsignedBigInteger('semester_id')->unsigned();
            $table->string('kode_cp', 10);
            $table->string('capaian_pembelajaran');
            $table->string('ringkasan_cp', 150);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('tingkatan_id')->references('id')->on('tingkatans')->onDelete('cascade');
            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capaian_pembelajarans');
    }
}
