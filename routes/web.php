<?php

use App\Http\Controllers\ProductoController;

use App\Http\Controllers\Auth\RegisteredUserController;

Route::resource('productos', ProductoController::class);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')    
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);
    //->middleware('guest');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('productos', ProductoController::class);
});
