<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        // Este método debería retornar la vista con el usuario autenticado
        $user = Auth::user();
        return view('mi-cuenta', compact('user'));
    }

    public function mostrarCuenta()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }
        // Convertir fecha_nacimiento a un objeto Carbon si no es nulo
        if ($user->fecha_nacimiento) {
            $user->fecha_nacimiento = Carbon::parse($user->fecha_nacimiento);
        }
        // Verifica si el usuario ha completado todos los campos obligatorios
        if (empty($user->nombre) || empty($user->apellido) || empty($user->apodo) || empty($user->sexo) || 
            empty($user->pais) || empty($user->fecha_nacimiento) || empty($user->descripcion) || 
            empty($user->foto)) {
            return redirect()->route('perfil.editar');
        }
        return view('mi-cuenta', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('editar-perfil', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'sexo' => 'nullable|string',
            'pais' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'apodo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->sexo = $request->sexo;
        $user->pais = $request->pais;
        $user->fecha_nacimiento = $request->fecha_nacimiento;

        if ($request->hasFile('foto')) {
            $user->foto = $request->file('foto')->store('fotos', 'public');
        }

        $user->apodo = $request->apodo;
        $user->descripcion = $request->descripcion;

        $user->save();

        return redirect()->route('mi-cuenta')->with('success', 'Cuenta actualizada correctamente. ¡Gracias! :D');
    }
}
