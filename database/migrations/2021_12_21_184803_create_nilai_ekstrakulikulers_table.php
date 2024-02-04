<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiEkstrakulikulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ekstrakulikuler', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ekstrakulikuler_id')->unsigned();
            $table->unsignedBigInteger('anggota_ekstrakulikuler_id')->unsigned();
            $table->enum('nilai', ['A', 'B', 'C', 'D']);
            $table->string('deskripsi', 200);
            $table->timestamps();
            $table->softDeletes();            
            
            $table->foreign('ekstrakulikuler_id')->references('id')->on('ekstrakulikuler')->onDelete('cascade');
            $table->foreign('anggota_ekstrakulikuler_id')->references('id')->on('anggota_ekstrakulikuler')->onDelete('cascade');
        });

        // Nilai
        // 1 = Kurang 
        // 2 = Cukup
        // 3 = Baik 
        // 4 = Sangat Baik
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_ekstrakulikuler');
    }
}
