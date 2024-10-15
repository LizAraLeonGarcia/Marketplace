<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Ruta de inicio (index.blade.php)
Route::get('/', function () {
    return view('index');
})->name('inicio');

// Rutas de registro
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Rutas de login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Ruta para cerrar sesión
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Ruta para acceder a la lista de productos (pública)
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

// Ruta para soporte
Route::get('/soporte', function () {
    return view('soporte'); // Cambia 'soporte' por la vista de soporte si tienes una específica
})->name('soporte');

// Ruta para la página "Acerca de"
Route::get('/about', function () {
    return view('about'); // Cambia 'about' por la vista de "Acerca de" si tienes una específica
})->name('about');

// Rutas del CRUD de productos (solo accesibles para usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    // Rutas del CRUD de productos
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    // Ruta para el dashboard (Mi Cuenta)
    Route::get('/dashboard', [ProductoController::class, 'dashboard'])->name('dashboard');
});
