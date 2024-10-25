<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image; // Asegúrate de importar el modelo Image
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Importa Auth para obtener el ID del usuario autenticado

class ProductoController extends Controller
{
    // ----------------------------------------------------------------------------------------------- Los usuarios autenticados acceden al CRUD
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); 
    }

    // -------------------------------------------------------------------------------------- Listar todos los productos o filtrar por categoría
    public function index(Request $request)
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();

        // Verificar si se ha enviado una categoría para filtrar
        if ($request->has('categoria_id') && $request->categoria_id != null) {
            $productos = Producto::where('categoria_id', $request->categoria_id)->paginate(10);
        } else {
            // Obtener todos los productos
            $productos = Producto::paginate(10); 
        }

        return view('productos.index', compact('productos', 'categorias'));
    }

    // ------------------------------------------------------------------------------------------------------- Mostrar el formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    // ------------------------------------------------------------------------------------------- Guardar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id', // Validación de categoría
            'imagenes.*' => 'image|mimes:jpg,png,jpeg|max:2048', // Validación de múltiples imágenes
        ]);

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'user_id' => auth()->id(), // Asignar el ID del usuario autenticado
            'vendedor_id' => auth()->id(), // Asignar el vendedor actual al producto (usuario autenticado)
        ]);

        // Manejo de imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $path = $image->store('products', 'public'); // Guardar cada imagen
                $producto->images()->create(['path' => $path]); // Guardar la relación en la base de datos
            }
        }

        // Activar el rol de vendedor si aún no lo tiene
        if (!Auth::user()->is_vendedor) {
            Auth::user()->is_vendedor = true;
            Auth::user()->save();
        }          

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');        
    }

    // ------------------------------------------------------------------------------------------ Mostrar los detalles de un producto específico
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    // ----------------------------------------------------------------------------------------- Mostrar el formulario de edición de un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all(); 
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // ---------------------------------------------------------------------------------------------- Actualizar el producto en la base de datos
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Actualizar el resto de los campos
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id, // Cambia a 'categoria_id'
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    // ------------------------------------------------------------------------------------------------ Eliminar un producto de la base de datos
    public function destroy(Producto $producto)
    {
        // Eliminar las imágenes asociadas del sistema de archivos
        foreach ($producto->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete(); // Eliminar el registro de la base de datos
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    // ------------------------------------------------------------------------------------------------------------- Categorias de los productos
    public function categoria($categoria)
    {
        $productos = Producto::where('categoria_id', $categoria)->paginate(10);
        return view('productos.categoria', compact('productos', 'categoria'));
    }

    // --------------------------------------------------------------------------------- Dashboard para usuarios autenticados donde verá el CRUD
    public function dashboard()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();
        // Obtener productos del usuario autenticado
        $productos = Producto::where('user_id', $user->id)->paginate(10);
        // Obtener todas las categorías
        $categorias = Categoria::all(); 
        return view('dashboard', compact('productos', 'categorias'));
    }
}
