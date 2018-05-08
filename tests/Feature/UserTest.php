<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function showsUserList()
    {

        factory(User::class)->create([
            "name" => "Jhon",
            "lastname" => "Doe",
            "second_lastname" => "Smith",
            "access_level" => "admin",
            "status" => "activo"
        ]);

        factory(User::class)->create([
            "name" => "Pedro",
            "lastname" => "Perez",
            "access_level" => "superAdmin",
            "status" => "activo"
        ]);


        $this->get("/user")
            ->assertStatus(200)
            ->assertSee("Equipo")
            ->assertSee("Jhon")
            ->assertSee("Pedro");
    }

    /** @test */
    public function getTheCorrectUser()
    {
        $user = factory(User::class)->create([
            "name" => "Jhon",
            "lastname" => "Doe",
            "second_lastname" => "Smith",
            "access_level" => "admin",
            "status" => "activo"
        ]);

        $this->get("/user/$user->id")->assertStatus(200)->assertSee("Jhon");
    }
}
