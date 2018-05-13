<?php
//Rutas del equipo de trabajo
Route::group(['middleware' => 'auth'], function () {
    Route::resource("user", "UserController");

});
Route::get('', 'HomeController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
