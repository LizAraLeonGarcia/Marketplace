<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // Listar todos los productos o filtrar por categoría
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        // Verificar si se ha enviado una categoría para filtrar
        if ($request->has('categoria_id') && $request->categoria_id != null) {
            $productos = Producto::where('categoria_id', $request->categoria_id)->paginate(10);
        } else {
            $productos = Producto::paginate(10); // Mostrar todos los productos
        }
        return view('productos.index', compact('productos', 'categorias'));
    }
    /*public function index()
    {
        $productos = Producto::paginate(10);
        $categorias = Categoria::all();
        return view('productos.index', compact('productos','categorias' ));
    }*/
    // Mostrar el formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }
    // Guardar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id', // Validación de categoría
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        // Comprobar si se ha subido una imagen
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public'); // Guardar la imagen en el disco 'public'
        } else {
            $imagenPath = null; // Si no hay imagen, asignar null
        }

        // Crear el producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'imagen' => $imagenPath, // Guardar la ruta de la imagen en el producto
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }
    // Mostrar los detalles de un producto específico
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }
    // Mostrar el formulario de edición de un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all(); // Asegúrate de que esto esté aquí
        return view('productos.edit', compact('producto', 'categorias'));
    }
    // Actualizar el producto en la base de datos
    public function update(Request $request, Producto $producto)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Si se sube una imagen nueva, eliminar la anterior y guardar la nueva
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('imagenes_productos', 'public');
        }
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
    // Eliminar un producto de la base de datos
    public function destroy(Producto $producto)
    {
        // Eliminar la imagen del sistema de archivos
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
    
    public function categoria($categoria)
    {
        dd($categoria); // Esto imprimirá el valor de la categoría
        $productos = Producto::where('categoria', $categoria)->paginate(10);
        return view('productos.categoria', compact('productos', 'categoria'));
    }

    public function dashboard()
    {
        // Obtener todos los productos
        $productos = Producto::paginate(10); // Obtener los productos paginados
        $categorias = Categoria::all(); // Obtener todas las categorías
        return view('dashboard', compact('productos', 'categorias'));
    }
}
