<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        // Busca el usuario por ID o lanza una excepción si no se encuentra
        $user = User::findOrFail($id);
        
        // Verifica el hash del correo electrónico
        if (!hash_equals((string) $hash, (string) sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }
        
        // Marca el correo electrónico como verificado
        $user->markEmailAsVerified();    

        // Autentica al usuario después de la verificación
        Auth::login($user);
        
        // Redirige al usuario a su dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', '¡Correo electrónico verificado exitosamente!');      
    }
}
