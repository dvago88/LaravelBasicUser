<?php
Route::resource("user", "UserController");
Route::get('/user/form/{accion?}', 'UserController@create');
Route::get('/user/create}', 'UserController@create');
