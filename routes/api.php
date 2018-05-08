<?php

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


Route::post('/user/changestatus', function (Request $request) {
    $user = User::find($request->id);
    if($user->status=="activo"){
        $user->status = "inactivo";
    }else{
        $user->status = "activo";
    }
    $user->save();
    return $user->status;
})->name("user.changestatus");
