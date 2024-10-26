<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;

class VerificationController extends Controller
{
    // Este método maneja la verificación del correo electrónico.
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        // Verifica el hash del correo electrónico
        if (!hash_equals((string) $hash, (string) $user->getEmailForVerification())) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }
        // Marca el correo electrónico como verificado
        $user->markEmailAsVerified();    
        // Autenticar al usuario después de la verificación
        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', '¡Correo electrónico verificado exitosamente!');
    }
    // Este método puede ser llamado después de que el usuario se registre.
    public function sendVerificationEmail(User $user)
    {
        $user->notify(new CustomVerifyEmail);
    }
    // Este método maneja la redirección después de la verificación.
    protected function verified(Request $request)
    {
        return redirect('/dashboard')->with('success', '¡Correo verificado con éxito!');
    }
}
