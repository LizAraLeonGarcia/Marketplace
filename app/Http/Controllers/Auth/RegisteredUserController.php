<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisteredUserController extends Controller
{
    // ***************************************************************** crear *****************************************************************
    public function create()
    {
        return view('auth.register');
    }
    // ***************************************************************** store *****************************************************************
    public function store(Request $request)
    {
        // ---------------------------------------------------------------------------------------- validar el request directamente en el método
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // -------------------------------------------------------------------------------------------------------------------- crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // ------------------------------------------------------------------------------------ enviar la notificación de verificación de correo
        $user->notify(new CustomVerifyEmail()); 
        // --------------------------------------------------------------------------------------------------------------- autenticar al usuario
        auth()->login($user);    
        // -------------------------------------------------------------------- redirigir al usuario con un mensaje para que verifique su correo
        return redirect('/')->with('success', 'Usuario registrado con éxito. Por favor, verifica tu correo electrónico.')->with('status', 'verification-link-sent');
    }
}