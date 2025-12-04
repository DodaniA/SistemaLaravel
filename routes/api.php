<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/user/{id}/completo', [UserController::class, 'completo']);  //api para saber si el usuario ya completo su informacion devuelve boleano
