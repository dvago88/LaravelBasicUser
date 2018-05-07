<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Model\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Jhon",
            "lastname" => "Doe",
            "second_lastname" => "Smith",
            "birth_date" => Carbon::parse('2000-01-01'),
            "cellphone" => 3001234567,
            "personal_email" => "jhondoe@personal.com",
            "business_email" => "jhondoe@empresarial.com",
            "position" => "desarrollador",
            "password" => "pass",
            "access_level" => "desarrollador",
            "status" => "activo"
        ]);

        User::create([
            "name" => "Pedro",
            "lastname" => "Perez",
            "birth_date" => Carbon::parse('1993-12-11'),
            "cellphone" => 3009876541,
            "personal_email" => "pedroperez@personal.com",
            "business_email" => "pesroperez@empresarial.com",
            "position" => "lider",
            "password" => "pass",
            "access_level" => "lider",
            "status" => "activo"
        ]);

    }
}