<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Model\User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'lastname' => $faker->lastName,
        'second_lastname' => $faker->lastName,
        "birth_date" => $faker->dateTimeThisCentury,
        "cellphone" => $faker->unique()->creditCardNumber,
        'personal_email' => $faker->unique()->safeEmail,
        'business_email' => $faker->unique()->companyEmail,
        "position" => $faker->jobTitle,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
