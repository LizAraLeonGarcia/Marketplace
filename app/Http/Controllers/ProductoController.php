<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{   // ----------------------------------------------------------------------------------------------------------- Listar todos los productos
    public function index()
    {
        // Cambia all() por paginate(10) para paginar los productos
        $productos = Producto::paginate(10);  // Obtener productos paginados
        return view('productos.index', compact('productos'));  // Pasar los productos a la vista
    }
    // ---------------------------------------------------------------------------------------------------- Mostrar el formulario de creación
    public function create()
    {
        return view('productos.create');
    }
    // ---------------------------------------------------------------------------------------- Guardar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $request->validate
        ([
            'id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vendedor_id' => 'required|integer',
        ]);
        // Manejo de la imagen
        if ($request->hasFile('imagen'))
        {
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public');
        }
        // Crear el producto
        Producto::create
        ([
            'id' => $request->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->cantidad,
            'imagen' => $imagenPath ?? null,
            'vendedor_id' => $request->vendedor_id,
        ]);
        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }
    // --------------------------------------------------------------------------------------- Mostrar los detalles de un producto específico
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }
    // -------------------------------------------------------------------------------------- Mostrar el formulario de edición de un producto
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }
    // ------------------------------------------------------------------------------------------- Actualizar el producto en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate
        ([
            'id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vendedor_id' => 'required|integer',
        ]);

        $producto = Producto::findOrFail($id);
        // Manejo de la imagen
        if ($request->hasFile('imagen')) 
        {
            // Eliminar la imagen anterior si existe
            if ($producto->imagen) 
            {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public');
            $producto->imagen = $imagenPath; // Actualiza el campo imagen
        }
        // Actualizar el producto
        $producto->id = $request->id;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->cantidad;
        $producto->vendedor_id = $request->vendedor_id;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }
    // --------------------------------------------------------------------------------------------- Eliminar un producto de la base de datos
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}