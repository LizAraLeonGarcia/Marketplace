<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Notifications\CustomVerifyEmail;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validar el request directamente en el método
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Lanzar el evento para el envío del correo de verificación
        //event(new Registered($user));
        // Enviar la notificación de verificación de correo
        $user->notify(new CustomVerifyEmail()); 
        // Autenticar al usuario
        auth()->login($user);    
        // Redirigir al usuario con un mensaje para que verifique su correo
        return redirect('/')->with('success', 'Usuario registrado con éxito. Por favor, verifica tu correo electrónico.')->with('status', 'verification-link-sent');
    }
}
