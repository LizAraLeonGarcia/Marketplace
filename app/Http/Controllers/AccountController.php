<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pais;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mi-cuenta', compact('user'));
    }

    public function mostrarCuenta()
    {
        $user = auth()->user();
        // Si el usuario no ha completado todos los campos requeridos, redirige a la edición de perfil
        $camposObligatorios = ['nombre', 'apellido', 'apodo', 'sexo', 'pais', 'fecha_nacimiento', 'descripcion', 'foto'];
        foreach ($camposObligatorios as $campo) {
            if (empty($user->$campo)) {
                return redirect()->route('perfil.editar');
            }
        }
        // Convertir fecha_nacimiento a un objeto Carbon si no es nulo
        if ($user->fecha_nacimiento) {
            $user->fecha_nacimiento = Carbon::parse($user->fecha_nacimiento);
        }

            return view('mi-cuenta', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user()->load('pais');
        $paises = Pais::all();

        return view('editar-perfil', compact('user', 'paises'));
    }

    public function update(Request $request)
    {        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'apodo' => 'nullable|string|max:255',
            'sexo' => 'required|string',
            'pais' => 'required|exists:paises,id',
            'fecha_nacimiento' => 'required|date',
            'descripcion' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Actualización de datos
        $user = auth()->user();
        // Actualiza los campos del usuario
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->apodo = $request->apodo;
        $user->sexo = $request->sexo;
        $user->pais = $request->pais;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->descripcion = $request->descripcion;
        // Manejo de la foto
        if ($request->hasFile('foto')) {
            // Guarda la imagen en el almacenamiento
            $path = $request->file('foto')->store('fotos', 'public'); // Almacena en 'storage/app/public/fotos'
            $user->foto = $path; // Asigna la ruta al campo 'foto' del usuario
        }
        // Guarda los cambios en la base de datos
        $user->save();

        return redirect()->route('mi-cuenta')->with('success', 'Cuenta actualizada correctamente.');
    }
}
