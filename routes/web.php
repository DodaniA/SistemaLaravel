<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Livewire\FormularioMedico;
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::view('usuarios', 'usuarios')
    ->middleware(['auth', 'verified'])
    ->name('usuarios');
    Route::view('medicamentos-inventario', 'medicamentos-inventario')
    ->middleware(['auth', 'verified'])
    ->name('medicamentos-inventario');
Route::view('materias', 'materias')
    ->middleware(['auth', 'verified'])
    ->name('materias');

Route::view('inscripciones', 'inscripciones')
    ->middleware(['auth', 'verified'])
    ->name('inscripciones');
Route::view('citas', 'citas')
    ->middleware(['auth', 'verified'])
    ->name('citas');
Route::view('calificaciones', 'calificaciones')
    ->middleware(['auth', 'verified'])
    ->name('calificaciones');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
