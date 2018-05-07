<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('home')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($accion = "crear", $id = 0)
    {
        if ($accion == "crear") {
            return view("user_form", ["accion" => "Crear"]);
        }
        if ($accion == "actualizar") {
            $user = User::find($id);
            return view("user_form", ["user" => $user, "accion" => "Actualizar"]);

        }
        return Redirect::to('/')->with('message', "Parametro $accion no reconocido");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = Input::get("nombre");
        $user->lastname = Input::get("primer_apellido");
        $user->second_lastname = Input::get("segundo_apellido");
        $user->brith_date = Input::get("fecha_nacimiento");
        $user->cellphone = Input::get("celular");
        $user->personal_email = Input::get("correo_personal");
        $user->business_email = Input::get("correo_empresarial");
        $user->position = Input::get("cargo");
        $user->password = Input::get("contraseña");
        $user->access_level = Input::get("nivel_acceso");
        $user->status = "activo";
        $user->save();

        return Redirect::route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user', ["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     */
    public function edit($id)
    {
        return $this->create("actualizar", $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return Redirect::to('/user/form/crear');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "Not ready yet";
    }

    public function form($accion)
    {

    }
}
