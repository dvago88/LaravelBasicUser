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
        return view('user_home')->with('users', $users);
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


    public function store(Request $request)
    {
        $data = request()->validate([
            "id" => "",
            "name" => "required",
            "lastname" => "required|max:35",
            "second_lastname" => "max:35",
            "birth_date" => "required",
            "cellphone" => "required|unique:users,cellphone",
            "email" => "required|unique:users,email|email|max:70",
            "business_email" => "required|unique:users,business_email|email|max:70",
            "position" => "required|max:70",
            "password" => "required|min:6",
            "passwordChecker" => "required|min:6",
            "access_level" => "required",
        ], [
            "name.required" => "El nombre es obligatorio"
//            TODO: Finish this messages
        ]);

        if ($data["password"] != $data["passwordChecker"]) {
            session()->flash("passwordDifferent", "Contraseñas no pueden ser diferentes");
            return Redirect::back()->withInput($data)->withErrors([]);
        }

        $user = new User();
        $password = bcrypt($data["password"]);
        $user->name = $data["name"];
        $user->second_lastname = $data["lastname"];
        $user->second_lastname = $request->second_lastname;
        $user->birth_date = $data["birth_date"];
        $user->cellphone = $data["cellphone"];
        $user->email = $data["email"];
        $user->business_email = $data["business_email"];
        $user->position = $data["position"];
        $user->password = $password;
        $user->access_level = $data["access_level"];
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
            "name" => "required",
            "lastname" => "required|max:35",
            "second_lastname" => "max:35",
            "birth_date" => "required",
            "cellphone" => "required|unique:users,cellphone,$id",
            "email" => "required|unique:users,email,$id|email|max:70",
            "business_email" => "required|unique:users,business_email,$id|email|max:70",
            "position" => "required|max:70",
            "oldPassword" => "",
            "password" => "",
            "passwordChecker" => "min:6",
            "access_level" => "required",
        ]);
        $user = User::find($id);


        try {
            $password = $this->changePassword($user, $data["oldPassword"], $data["password"], $data["passwordChecker"]);

        } catch (ErrorException $e) {
            $password = $user->password;
        }
        $user->name = $data["name"];
        $user->second_lastname = $data["lastname"];
        $user->second_lastname = Input::get("second_lastname");
        $user->birth_date = $data["birth_date"];
        $user->cellphone = $data["cellphone"];
        $user->email = $data["email"];
        $user->business_email = $data["business_email"];
        $user->position = $data["position"];
        $user->password = $password;
        $user->access_level = strtolower($data["access_level"]);
        $user->status = "activo";
        $user->update();

        return redirect()->route("user.show", $user);
    }

    public function destroy($id)
    {
//        TODO: Use soft-delete
        User::find($id)->delete();
        return redirect()->route("user.index");
    }


    private function changePassword($user, $oldP, $newP, $newPChecker)
    {
        $passwordIsOk = password_verify($oldP, $user->password);

        if ($passwordIsOk && rtrim(trim($newP)) == rtrim(trim($newPChecker)) && rtrim(trim($newP)) != "") {
            session()->flash("passwordSuccess", "Contraseña actualizada correctamente");
            return bcrypt($newP);
        }
        session()->flash("passwordFail", "Contraseña No actualizada");
        return $user->password;
    }
}
