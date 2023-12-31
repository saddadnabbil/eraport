<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeniliaanKurikulumMerdekasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peniliaan_kurikulum_merdekas', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai_akhir');
            $table->integer('nilai_revisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peniliaan_kurikulum_merdekas');
    }
}
