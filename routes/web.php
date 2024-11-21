<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\MetodoDePagoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AyudaController;
use App\Http\Controllers\FileController;
// ****************************************************** Habilitar verificación de email ******************************************************
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard')->with('success', '¡Correo electrónico verificado exitosamente!');
})->middleware(['auth', 'signed'])->name('verification.verify');
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
// *********************************************************** Ruta para "Acerca de" ***********************************************************
Route::get('/about', function () {
    return view('about');
})->name('about');
// ************************************************ Rutas accesibles para usuarios autenticados ************************************************
Route::middleware(['auth'])->group(function () {
    // ------------------------------------------------------ Rutas del CRUD de productos ------------------------------------------------------
    Route::get('/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
    Route::get('/productos/precio', [ProductoController::class, 'porPrecio'])->name('productos.precio');
    Route::get('/productos/ofertas', [ProductoController::class, 'ofertas'])->name('productos.ofertas');
    Route::get('/productos/recomendaciones', [ProductoController::class, 'recomendaciones'])->name('productos.recomendaciones');
    Route::get('/productos/mas-vendidos', [ProductoController::class, 'masVendidos'])->name('productos.mas-vendidos');
    Route::get('/productos/nuevos', [ProductoController::class, 'nuevosProductos'])->name('productos.nuevos');
    Route::resource('productos', ProductoController::class);
    Route::get('/productos/categoria/{id}', [ProductoController::class, 'porCategoria'])->name('productos.categoria');
    // ---------------------------------------------------------- Ruta para dashboard ----------------------------------------------------------
    Route::get('/dashboard', [ProductoController::class, 'dashboard'])->name('dashboard');
    // --------------------------------------------------------------- mi cuenta ---------------------------------------------------------------
    Route::get('/cuenta/mi-cuenta', [AccountController::class, 'mostrarCuenta'])->name('mi-cuenta');
    // editar ..................................................................................................................................
    Route::get('/cuenta/mi-cuenta/editar', [AccountController::class, 'edit'])->name('cuenta.editar');
    // actualizar ..............................................................................................................................
    Route::post('/cuenta/mi-cuenta/actualizar', [AccountController::class, 'update'])->name('cuenta.actualizar');
    // eliminar ................................................................................................................................
    // mostrar la vista de eliminar cuenta
    Route::get('/cuenta/mi-cuenta/eliminar', function () {return view('cuenta.eliminar-cuenta'); })->name('cuenta.eliminar.form')->middleware('auth');
    // manejar la eliminación de la cuenta
    Route::delete('/cuenta/mi-cuenta/eliminar', [AccountController::class, 'eliminarCuenta'])->name('cuenta.eliminar')->middleware('auth');
    // cambiar la contraseña ...................................................................................................................
    // mostrar la vista de cambiar contraseña
    Route::get('/cuenta/cambiar-contrasena', [AccountController::class, 'mostrarFormularioCambioContrasena'])->name('cuenta.cambiar-contrasena.form');
    // manejar el cambio de contraseña
    Route::post('/cuenta/cambiar-contrasena', [AccountController::class, 'cambiarContrasena'])->name('cuenta.cambiar-contrasena.update');
    // metodo pago .............................................................................................................................
    Route::get('/cuenta/metodo-de-pago', [MetodoDePagoController::class, 'showMetodoDePagoForm'])->name('metodo-de-pago.show');
    Route::post('/cuenta/metodo-de-pago', [MetodoDePagoController::class, 'storeMetodoDePago'])->name('metodo-de-pago.store');
    // ----------------------------------------------------------- perfil comprador -----------------------------------------------------------
    Route::get('/cuenta/comprador', [UserProfileController::class, 'perfilComprador'])->name('comprador.perfil');
    // ------------------------------------------------------------ perfil vendedor ------------------------------------------------------------
    Route::get('/cuenta/vendedor', [UserProfileController::class, 'perfilVendedor'])->name('vendedor.perfil');       
    // historial de pedidos ....................................................................................................................
    Route::get('/cuenta/mi-cuenta/historial', [AccountController::class, 'historial'])->name('historial.pedidos');
    // reseñas .................................................................................................................................
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    // ---------------------------------------------------------------- carrito ----------------------------------------------------------------
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar'); 
    Route::delete('/carrito/eliminar/{producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/pagar', [CarritoController::class, 'pagar'])->name('carrito.pagar');
    Route::get('/pago-exitoso', [CarritoController::class, 'pagoExitoso'])->name('carrito.pago-exitoso');
    Route::get('/checkout', [CarritoController::class, 'checkout'])->name('checkout');
    //Route::get('/productos/{id}/detalles', [ProductoController::class, 'detalles'])->name('productos.show');
    // ------------------------------------------------------------- sección ayuda -------------------------------------------------------------
    Route::get('/ayuda', [AyudaController::class, 'index'])->name('ayuda.index');



    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::put('/files/{id}', [FileController::class, 'update'])->name('files.update');
    Route::get('/files/create', [FileController::class, 'create'])->name('files.create');
});
