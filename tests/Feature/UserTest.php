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

        $this->from(route("user.index"))->post("/user", [
            "id" => 0,
            "nombre" => "name01",
            "primer_apellido" => "lastname01",
            "fecha_nacimiento" => "2000-01-01",
            "celular" => 555555555,
            "correo_personal" => "test@test.com",
            "correo_empresarial" => "test01@test01.com",
            "cargo" => "desarrollador",
            "contraseña" => bcrypt("55555"),
            "nivel_acceso" => "superAdmin",
        ])->assertRedirect(route("user.index"));

        $this->assertDatabaseHas("users", [
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => "555555555",
            "personal_email" => "test@test.com",
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
            "primer_apellido" => "lastname01",
            "fecha_nacimiento" => "2000-01-01",
            "celular" => 555555555,
            "correo_personal" => "test@test.com",
            "correo_empresarial" => "test01@test01.com",
            "cargo" => "desarrollador",
            "contraseña" => bcrypt("55555"),
            "nivel_acceso" => "superAdmin",
        ])->assertRedirect(route("user.create"))
            ->assertSessionHasErrors(["nombre"]);

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
            "nombre" => "name01",
            "primer_apellido" => "lastname01",
            "fecha_nacimiento" => "2000-01-01",
            "celular" => 555555555,
            "correo_personal" => "test@test.com",
            "correo_empresarial" => "test01@test01.com",
            "cargo" => "desarrollador",
            "estado" => "activo",
            "nivel_acceso" => "admin"

        ])->assertRedirect(route("user.index"));

        $this->assertDatabaseHas("users", [
            "id" => $user->id,
            "name" => "name01",
            "lastname" => "lastname01",
            "birth_date" => "2000-01-01",
            "cellphone" => "555555555",
            "personal_email" => "test@test.com",
            "business_email" => "test01@test01.com",
            "position" => "desarrollador",
        ]);
    }


    /** @test */
    public function changePasswordWorks()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            "password" => bcrypt("pass"),
            "access_level" => "admin",
            "status" => "activo"
        ]);

//        $this->post("/user", [
        $this->put("/user/$user->id", [
            "id" => $user->id,
            "nombre" => $user->name,
            "primer_apellido" => $user->lastname,
            "fecha_nacimiento" => $user->birth_date,
            "celular" => $user->cellphone,
            "correo_personal" => $user->personal_email,
            "correo_empresarial" => $user->business_email,
            "cargo" => $user->position,
            "contraseñaAntigua" => "pass",
            "contraseña" => "perro",
            "contraseñaRevisador" => "perro",
            "nivel_acceso" => $user->access_level,
        ])->assertRedirect(route("user.index"));

        $userUpdated = User::find($user->id);

        $samePass = Hash::check('perro', $userUpdated->password);
        $this->assertTrue($samePass);
    }


    /** @test */
    public function changePasswordWithWrongPasswordWontWork()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            "password" => bcrypt("pass"),
            "access_level" => "admin",
            "status" => "activo"
        ]);

//        $this->post("/user", [
        $this->put("/user/$user->id", [
            "id" => $user->id,
            "nombre" => $user->name,
            "primer_apellido" => $user->lastname,
            "fecha_nacimiento" => $user->birth_date,
            "celular" => $user->cellphone,
            "correo_personal" => $user->personal_email,
            "correo_empresarial" => $user->business_email,
            "cargo" => $user->position,
            "contraseñaAntigua" => "passo",
            "contraseña" => "perro",
            "contraseñaRevisador" => "perro",
            "nivel_acceso" => $user->access_level,
        ])->assertRedirect(route("user.index"));

        $userUpdated = User::find($user->id);

        $samePass = Hash::check('perro', $userUpdated->password);
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
            "fecha_nacimiento" => "2000-01-01",
            "celular" => 555555555,
            "correo_personal" => "test@test.com",
            "correo_empresarial" => "test01@test01.com",
            "cargo" => "desarrollador",
            "contraseña" => bcrypt("55555"),
            "nivel_acceso" => "superAdmin",
        ])->assertRedirect(route("user.edit", ["id" => $user->id]))
            ->assertSessionHasErrors(["nombre"]);

        $this->assertDatabaseMissing("users", ["name" => "name01"]);
    }
}
