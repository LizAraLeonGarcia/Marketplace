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
        $defaultProfileImages = [
            'alien.jpg', 'angel.jpg', 'bat.jpg', 'blackCat.jpg', 'candyApple.jpg', 'candyCorn.jpg', 'clown.jpg', 'cottonCandy.jpg', 'devil.jpg',
            'dracula.jpg', 'fairy.jpg', 'frankenstein.jpg', 'ghost.jpg', 'grimReaper.jpg', 'medusa.jpg', 'mothman.jpg', 'mummy.jpg', 
            'mushroom.jpg', 'pirate.jpg', 'pumpkin.jpg', 'pumpkinPie.jpg', 'scarecrow.jpg', 'skeleton.jpg', 'slime.jpg', 'spider.jpg',
            'voodoo.jpg', 'werewolf.jpg', 'witch.jpg', 'zombie.jpg'
        ];

        $user = Auth::user()->load('pais');
        $paises = Pais::all();

        return view('cuenta.editar-cuenta', compact('user', 'paises', 'defaultProfileImages'));
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
            'profile_image' => 'nullable|string'
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
        // Verifica si se seleccionó una imagen predeterminada
        if ($request->has('profile_image') && strpos($request->profile_image, 'default') !== false) {
            // Guarda la ruta de la imagen predeterminada seleccionada
            $user->foto = '/img/imagenesPerfil/' . $request->profile_image;
        } else if ($request->hasFile('uploaded_image')) {
            // Si el usuario subió una imagen, guárdala y actualiza la ruta en el perfil
            $path = $request->file('foto')->store('fotos', 'public');
            $user->foto = '/storage/' . $path;
        }
        // Guarda los cambios en la base de datos
        $user->save();

        return redirect()->route('mi-cuenta')->with('success', 'Cuenta actualizada correctamente.');
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
    // ------------------------------------------------------------------------------------------------------ imagenes de perfil predeterminadas
    public function editProfile()
    {
        $defaultProfileImages = [
            'alien.jpg', 'angel.jpg', 'bat.jpg', 'blackCat.jpg', 'candyApple.jpg', 'candyCorn.jpg', 'clown.jpg', 'cottonCandy.jpg', 'devil.jpg',
            'dracula.jpg', 'fairy.jpg', 'frankenstein.jpg', 'ghost.jpg', 'grimReaper.jpg', 'medusa.jpg', 'mothman.jpg', 'mummy.jpg',
            'mushroom.jpg', 'pirate.jpg', 'pumpkin.jpg', 'pumpkinPie.jpg', 'scarecrow.jpg', 'skeleton.jpg', 'slime.jpg', 'spider.jpg',
            'voodoo.jpg', 'werewolf.jpg', 'witch.jpg', 'zombie.jpg',
        ];
        return view('mi-cuenta', compact('defaultProfileImages'));
    }
}
