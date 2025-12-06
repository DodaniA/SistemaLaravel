<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/medicamentos', [ApiController::class, 'listaDeMedicamentos']);
Route::get('/tipos-sangre', [ApiController::class, 'tiposdesangre']);
Route::get('/especialidades', [ApiController::class, 'especialidades']);