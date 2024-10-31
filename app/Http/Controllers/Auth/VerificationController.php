<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('signed')->only('verify'); // Asegura que la ruta esté firmada
        $this->middleware('throttle:6,1')->only('verify'); // Limita la tasa de intentos
    }

    public function verify(Request $request, $id, $hash)
    {
        // Verifica si el usuario ya está verificado
        $user = User::findOrFail($id);
        // Redirige al dashboard si el correo ya ha sido verificado
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('message', '¡Tu correo ya estaba verificado!');
        }
        // Verifica que el hash en la URL coincida con el correo del usuario
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->withErrors(['message' => 'El enlace de verificación es inválido o ha expirado.']);
        }
        // Marca el correo electrónico como verificado
        $user->markEmailAsVerified();
        // Autentica al usuario después de la verificación
        Auth::login($user);
        // Redirige al usuario a su dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', '¡Correo electrónico verificado exitosamente!');
    }
}