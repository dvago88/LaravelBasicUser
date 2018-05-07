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
            $table->string('name',35);
            $table->string("lastname", 35);
            $table->string("second_lastname", 35)->nullable();
            $table->date("birth_date");
            $table->bigInteger("cellphone")->unique();
            $table->string('personal_email',70)->unique();
            $table->string("business_email", 70)->unique();
            $table->string("position", 70);
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
