<?php

namespace App\Http\Controllers;

use ErrorException;
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
        $data = request()->validate([
            "id" => "",
            "nombre" => "required",
            "primer_apellido" => "required|max:35",
            "segundo_apellido" => "max:35",
            "fecha_nacimiento" => "required",
            "celular" => "required|unique:users,cellphone",
            "correo_personal" => "required|unique:users,personal_email|email|max:70",
            "correo_empresarial" => "required|unique:users,business_email|email|max:70",
            "cargo" => "required|max:70",
            "contraseña" => "required|min:6",
            "nivel_acceso" => "required",
        ], [
            "nombre.required" => "El nombre es obligatorio"
//            TODO: Finish this messages
        ]);

        if ($data["id"] == 0) {
            $user = new User();
            $password = bcrypt($data["contraseña"]);
        } else {
            $user = User::find($data["id"]);
            try {
                $password = $this->changePassword($user, $data["contraseñaAntigua"], $data["contraseña"], $data["contraseñaRevisador"]);
            } catch (ErrorException $e) {
                $password = $user->password;
            }
        }
        $user->name = $data["nombre"];
        $user->lastname = $data["primer_apellido"];
//        $user->second_lastname = $data["segundo_apellido"]; //the tests wont pass like this...
        $user->second_lastname = Input::get("segundo_apellido");
        $user->birth_date = $data["fecha_nacimiento"];
        $user->cellphone = $data["celular"];
        $user->personal_email = $data["correo_personal"];
        $user->business_email = $data["correo_empresarial"];
        $user->position = $data["cargo"];
        $user->password = $password;
        $user->access_level = $data["nivel_acceso"];
        $user->status = "activo";

        $user->save();


        return redirect()->route("user.index");
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
        $data = request()->validate([
            "id" => "",
            "nombre" => "required",
            "primer_apellido" => "required|max:35",
            "segundo_apellido" => "max:35",
            "fecha_nacimiento" => "required",
            "celular" => "required|unique:users,cellphone,$id",
            "correo_personal" => "required|unique:users,personal_email,$id|email|max:70",
            "correo_empresarial" => "required|unique:users,business_email,$id|email|max:70",
            "cargo" => "required|max:70",
            "contraseñaAntigua" => "",
            "contraseña" => "",
            "contraseñaRevisador" => "",
            "nivel_acceso" => "required",
        ]);
        $user = User::find($id);


        try {
            $password = $this->changePassword($user, $data["contraseñaAntigua"], $data["contraseña"], $data["contraseñaRevisador"]);

        } catch (ErrorException $e) {
            $password = $user->password;
        }
        $user->name = $data["nombre"];
        $user->lastname = $data["primer_apellido"];
//        $user->second_lastname = $data["segundo_apellido"]; //the tests wont pass like this...
        $user->second_lastname = Input::get("segundo_apellido");
        $user->birth_date = $data["fecha_nacimiento"];
        $user->cellphone = $data["celular"];
        $user->personal_email = $data["correo_personal"];
        $user->business_email = $data["correo_empresarial"];
        $user->position = $data["cargo"];
        $user->password = $password;
        $user->access_level = $data["nivel_acceso"];
        $user->status = "activo";
        $user->update();

        return redirect()->route("user.index");
    }

    public function destroy($id)
    {
        return "Not ready yet";
    }

    public function form($accion)
    {

    }

    private function changePassword($user, $oldP, $newP, $newPChecker)
    {
        $passwordIsOk = password_verify($oldP, $user->password);

        if ($passwordIsOk && rtrim(trim($newP)) == rtrim(trim($newPChecker)) && rtrim(trim($newP)) != "") {
            return bcrypt($newP);
        }
        return $user->password;
    }
}
