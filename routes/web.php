<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AyudaController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\FileController;

// Habilitar verificación de email
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');    
//
Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('/files', [FileController::class, 'store'])->name('files.store');
Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
Route::put('/files/{id}', [FileController::class, 'update'])->name('files.update');
Route::get('/files/create', [FileController::class, 'create'])->name('files.create');

// ******************************************************* Ruta inicio (index.blade.php) *******************************************************
Route::get('/', function () {
    return view('index');
})->name('inicio');
// *************************************************************** Ruta registro ***************************************************************
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');
// **************************************************************** Ruta  login ****************************************************************
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');
// ********************************************************** Ruta para cerrar sesión **********************************************************
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
// ************************************************************* Ruta para soporte *************************************************************
Route::get('/soporte', function () {
    return view('soporte'); 
})->name('soporte');
// ****************************************************** Ruta para la página "Acerca de" ******************************************************
Route::get('/about', function () {
    return view('about');
})->name('about');
// ************************************************ Rutas accesibles para usuarios autenticados ************************************************
Route::middleware(['auth'])->group(function () {
    // ------------------------------------------------------ Rutas del CRUD de productos ------------------------------------------------------
    Route::resource('productos', ProductoController::class);
    Route::get('/productos/categoria/{categoria}', [ProductoController::class, 'categoria'])->name('productos.categoria');
    Route::get('/productos/precio', [ProductoController::class, 'porPrecio'])->name('productos.precio');
    Route::get('/productos/mas-vendidos', [ProductoController::class, 'masVendidos'])->name('productos.mas-vendidos');
    Route::get('/productos/nuevos', [ProductoController::class, 'nuevosProductos'])->name('productos.nuevos');
    // ---------------------------------------------------- Ruta para dashboard (Mi Cuenta) ----------------------------------------------------
    Route::get('/dashboard', [ProductoController::class, 'dashboard'])->name('dashboard');
    // ------------------------------------------------------------------------------------------------------------------------------- mi cuenta 
    Route::get('/mi-cuenta', [AccountController::class, 'mostrarCuenta'])->name('mi-cuenta');
    // editar ..................................................................................................................................
    Route::get('/mi-cuenta/editar', [AccountController::class, 'edit'])->name('perfil.editar');
    Route::post('/mi-cuenta/actualizar', [AccountController::class, 'update'])->name('perfil.actualizar');
    //
    Route::get('/perfil/comprador', [UserProfileController::class, 'perfilComprador'])->name('perfil.comprador');
    //
    Route::get('/vendedor', [UserProfileController::class, 'perfilVendedor'])->name('vendedor.perfil');       
    // historial de pedidos ....................................................................................................................
    Route::get('/mi-cuenta/historial', [AccountController::class, 'historial'])->name('historial.pedidos');
    // índice de ayuda .........................................................................................................................
    Route::get('/ayuda', [AyudaController::class, 'index'])->name('ayuda.index');
});
