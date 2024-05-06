<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP5NilaiProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p5_nilai_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_kelas_id');
            $table->unsignedBigInteger('p5_project_id');
            $table->json('grade_data')->nullable();
            $table->text('catatan_proses')->nullable();
            $table->timestamps();

            $table->foreign('anggota_kelas_id')->references('id')->on('anggota_kelas')->onDelete('cascade');
            $table->foreign('p5_project_id')->references('id')->on('p5_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p5_nilai_projects');
    }
}
