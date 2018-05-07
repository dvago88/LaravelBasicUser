<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string("lastname", 30);
            $table->string("second_lastname", 30)->nullable();
            $table->date("birth_date");
            $table->bigInteger("cellphone")->unique();
            $table->string('personal_email',50)->unique();
            $table->string("business_email", 50)->unique();
            $table->string("position", 50);
            $table->string('password');
            $table->enum("access_level", ["desarrollador", "lider", "admin", "superAdmin"]);
            $table->string("status");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
