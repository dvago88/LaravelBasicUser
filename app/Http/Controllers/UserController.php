<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('home')->with('users', $users);
    }


    public function create($accion = "crear", $id = 0)
    {
        if ($accion == "crear") {
            return view("user_form", ["accion" => "Crear"]);
        }
        if ($accion == "actualizar") {
            $user = User::find($id);
            return view("user_form", ["user" => $user, "accion" => "Actualizar"]);
        }
        return Redirect::to('/user')->with('message', "Parametro $accion no reconocido");
    }


    public function store()
    {
        if (Input::get("id") == 0) {
            $user = new User();
        }else{
            $user=User::find(Input::get("id"));
        }
            $user->name = Input::get("nombre");
            $user->lastname = Input::get("primer_apellido");
            $user->second_lastname = Input::get("segundo_apellido");
            $user->birth_date = Input::get("fecha_nacimiento");
            $user->cellphone = Input::get("celular");
            $user->personal_email = Input::get("correo_personal");
            $user->business_email = Input::get("correo_empresarial");
            $user->position = Input::get("cargo");
            $user->password = Input::get("contraseña");
            $user->access_level = Input::get("nivel_acceso");
            $user->status = "activo";

        $user->save();

        return $this->index();
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('user', ["user" => $user]);
        } catch (ModelNotFoundException $e) {
            return view("user", ["id" => $id]);
        }
    }

    public function edit($id)
    {
        return $this->create("actualizar", $id);
    }

    public function update(Request $request, $id)
    {
        return Redirect::to('/user/form/crear');
    }

    public function destroy($id)
    {
        return "Not ready yet";
    }

    public function form($accion)
    {

    }
}
