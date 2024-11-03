<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pais;
use Carbon\Carbon;

class AccountController extends Controller
{
    // ................................................................................................................................... index
    public function index()
    {
        $user = Auth::user();
        return view('cuenta.mi-cuenta', compact('user'));
    }
    // ................................................................................................................................. mostrar
    public function mostrarCuenta()
    {
        $user = auth()->user();
        // Si el usuario no ha completado todos los campos requeridos, redirige a la edición de perfil
        $camposObligatorios = ['nombre', 'apellido', 'sexo', 'pais', 'fecha_nacimiento', 'foto'];
        foreach ($camposObligatorios as $campo) {
            if (empty($user->$campo)) {
                return redirect()->route('cuenta.editar');
            }
        }
        // Convertir fecha_nacimiento a un objeto Carbon si no es nulo
        if ($user->fecha_nacimiento) {
            $user->fecha_nacimiento = Carbon::parse($user->fecha_nacimiento);
        }
        return view('cuenta.mi-cuenta', compact('user'));
    }
    // .................................................................................................................................. editar
    public function edit()
    {
        $user = Auth::user()->load('pais');
        $paises = Pais::all();

        return view('cuenta.editar-cuenta', compact('user', 'paises'));
    }
    // .............................................................................................................................. actualizar
    public function update(Request $request)
    {        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'apodo' => 'nullable|string|max:255',
            'sexo' => 'required|string',
            'pais_id' => 'required|exists:paises,id',
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
        $user->pais_id = $request->input('pais_id');
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

        return redirect()->route('cuenta.mi-cuenta')->with('success', 'Cuenta actualizada correctamente.');
    }
    // ................................................................................................................................ eliminar
    public function eliminarCuenta()
    {
        $user = Auth::user();
        // pendiente eliminar registros asociados
        // Eliminar el usuario
        $user->delete();
        // Cerrar la sesión
        Auth::logout();
        // Redirigir con mensaje de confirmación
        return redirect('index')->with('status', 'Tu cuenta ha sido eliminada correctamente.');
    }
    // ...................................................................................................................... cambiar contraseña
    public function mostrarFormularioCambioContrasena()
    {
        return view('cuenta.cambiar-contrasena');
    }

    public function cambiarContrasena(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Verifica que la contraseña actual sea correcta
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualiza la contraseña del usuario
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('cuenta.cambiar-contrasena')->with('status', 'Contraseña cambiada exitosamente.');
    }
}
