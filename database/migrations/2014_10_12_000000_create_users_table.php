<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11']);
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Role 
        // 0 = Super Admin
        // 1 = Admin 
        // 2 = Guru 
        // 3 = Siswa
        // 4 = Curriculum
        // 5 = HRD / Personel
        // 6 = Finance
        // 7 = Librarian
        // 8 = Admision / PSB Online
        // 9 = GA Inventory
        // 10 = Counter
        // 11 = Sales


        // Status 
        // true = Aktif 
        // false = Non Aktif 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
