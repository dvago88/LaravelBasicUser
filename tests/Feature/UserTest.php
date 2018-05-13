<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
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

    /** @test */
    public function formPostCreatesNewUser()
    {
//        $this->withoutExceptionHandling();


        $this->from(route("user.index"))->post("/user", [
            "id" => 0,
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => 555555555,
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
            "password" => "555555",
            "passwordChecker" => "555555",
            "access_level" => "superAdmin",
        ])->assertRedirect(route("user.index"));

        $this->assertDatabaseHas("users", [
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => "555555555",
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
            "access_level" => "superAdmin",
            "status" => "activo"
        ]);

//        $this->assertCredentials(["password" => "55555"]);
    }

//    TODO: Make tests for the other fields required

    /** @test */
    public function nameIsRequired()
    {
        $this->from(route("user.create"))->post("/user", [
            "id" => 0,
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => 555555555,
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
            "password" => bcrypt("55555"),
            "access_level" => "superAdmin",
        ])->assertRedirect(route("user.create"))
            ->assertSessionHasErrors(["name"]);

        $this->assertDatabaseMissing("users", ["name" => "name01"]);
    }


    /** @test */
    public function editUserWorks()
    {
        $user = factory(User::class)->create([
            "name" => "Jhon",
            "lastname" => "Doe",
            "second_lastname" => "Smith",
            "access_level" => "admin",
            "status" => "activo"
        ]);

        $this->put("/user/$user->id", [
            "id" => $user->id,
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => 555555555,
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
            "status" => "activo",
            "access_level" => "admin"

        ])->assertRedirect(route("user.show", $user));

        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => "555555555",
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
        ]);
    }


    /** @test */
    public function changePasswordWorks()
    {
//        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            "password" => bcrypt("pass"),
            "access_level" => "admin",
            "status" => "activo"
        ]);

//        $this->post("/user", [
        $this->put("/user/$user->id", [
            "id" => $user->id,
            "name" => $user->name,
            "lastname" => $user->lastname,
            "birth_date" => $user->birth_date,
            "cellphone" => $user->cellphone,
            "email" => $user->email,
            "business_email" => $user->business_email,
            "position" => $user->position,
            "oldPassword" => "pass",
            "password" => "perros",
            "passwordChecker" => "perros",
            "access_level" => $user->access_level,
        ])->assertRedirect(route("user.show", $user));

        $userUpdated = User::find($user->id);

        $samePass = Hash::check('perros', $userUpdated->password);
        $this->assertTrue($samePass);
    }


    /** @test */
    public function changePasswordWithWrongPasswordWontWork()
    {
//        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            "password" => bcrypt("pass"),
            "access_level" => "admin",
            "status" => "activo"
        ]);

//        $this->post("/user", [
        $this->put("/user/$user->id", [
            "id" => $user->id,
            "name" => $user->name,
            "lastname" => $user->lastname,
            "birth_date" => $user->birth_date,
            "cellphone" => $user->cellphone,
            "email" => $user->email,
            "business_email" => $user->business_email,
            "position" => $user->position,
            "oldPassword" => "passo",
            "password" => "perros",
            "passwordChecker" => "perros",
            "access_level" => $user->access_level,
        ])->assertRedirect(route("user.show", $user));

        $userUpdated = User::find($user->id);

        $samePass = Hash::check('perros', $userUpdated->password);
        $this->assertTrue(!$samePass);
        $samePass = Hash::check('pass', $userUpdated->password);
        $this->assertTrue($samePass);
    }

    /** @test */
    public function nameIsRequiredWhenUpdating()
    {

        $user = factory(User::class)->create([
            "name" => "Jhon",
            "lastname" => "Doe",
            "second_lastname" => "Smith",
            "access_level" => "admin",
            "status" => "activo"
        ]);

        $this->from(route("user.edit", ["id" => $user->id]))->put("/user/$user->id", [
            "birth_date" => "2000-01-01",
            "cellphone" => 555555555,
            "email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
            "password" => bcrypt("55555"),
            "access_level" => "superAdmin",
        ])->assertRedirect(route("user.edit", ["id" => $user->id]))
            ->assertSessionHasErrors(["name"]);

        $this->assertDatabaseMissing("users", ["name" => "name01"]);
    }

    /** @test */
    public function it_deletes_user()
    {
        $user = factory(User::class)->create([
            "access_level" => "admin",
            "status" => "activo"
        ]);

        $this->delete(route("user.destroy", ["id" => $user->id]))->assertRedirect(route("user.index"));
        $this->assertDatabaseMissing("users", ["id" => $user->id]);
        $this->assertSame(0, User::count());
    }


}
