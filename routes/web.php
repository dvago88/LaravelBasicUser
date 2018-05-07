<?php
Route::resource("user", "UserController");
Route::get('/user/form/{accion}', 'UserController@form');
