<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_kelas_id');
            $table->integer('no_school_days')->nullable();
            $table->integer('days_attended')->nullable();
            $table->integer('days_absent')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('tk_attendances');
    }
}
