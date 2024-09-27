<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{   // ----------------------------------------------------------------------------------------------------------- Listar todos los productos
    public function index()
    {
        $productos = Producto::all();  // Obtener todos los productos
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
        $this->authorize('create', Producto::class);
        // Validar el formulario
        $request->validate
        ([
            'id' => 'required|numeric',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'vendedor_id' => 'required|numeric',
        ]);
        // Crear el nuevo producto
        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
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
    public function update(Request $request, Producto $producto)
    {   
        $this->authorize('update', $producto);
        // Validar el formulario
        $request->validate
        ([
            'id' => 'required|numeric',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'vendedor_id' => 'required|numeric',
        ]);
        // Actualizar el producto
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
    // --------------------------------------------------------------------------------------------- Eliminar un producto de la base de datos
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}