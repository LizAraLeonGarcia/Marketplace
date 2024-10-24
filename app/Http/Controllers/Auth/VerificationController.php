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
        $user = User::findOrFail($id);

        // Verifica el hash del correo electrónico
        if (!hash_equals((string) $hash, (string) $user->getEmailForVerification())) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        // Marca el correo electrónico como verificado
        $user->markEmailAsVerified();

        // Opcionalmente, puedes autenticar al usuario después de la verificación
        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Correo electrónico verificado exitosamente!');
    }
    public function sendTestEmail()
    {
        $user = User::first(); // Obtén un usuario de prueba
        Mail::to($user->email)->send(new VerificacionEmail($user));
        return 'Correo de prueba enviado.';
    }

}
