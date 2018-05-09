<?php
Route::resource("user", "UserController");
Route::get('', 'UserController@index');