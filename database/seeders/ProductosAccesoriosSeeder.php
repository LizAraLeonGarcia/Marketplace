<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ProductosAccesoriosSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Obtener el usuario vendedor por su correo
            $user = User::where('email', 'b.armyforever333@gmail.com')->first();

            if (!$user) {
                $this->command->info("No se encontró un usuario con el correo 'b.armyforever333@gmail.com'.");
                return;
            }
            // Obtener el ID de la categoría 'Coleccionables' por su nombre
            $categoria = Categoria::where('nombre', 'Accesorios')->first();

            if (!$categoria) {
                $this->command->info("No se encontró la categoría 'Accesorios'. Asegúrate de tener esa categoría en la base de datos.");
                return;
            }
            // Crear productos para el usuario en la categoría 'Coleccionables'
            $productos = [
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 1
                    'nombre' => 'Llavero de vaca',
                    'descripcion' => 'Unico diseño',
                    'precio' => 49.99,
                    'stock' => 39,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/accesorios/a1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 2
                    'nombre' => 'Clip de ventilación de vaca',
                    'descripcion' => 'Unicos diseños',
                    'precio' => 89.00,
                    'stock' => 28,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/accesorios/b1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 3
                    'nombre' => 'Funda de celular',
                    'descripcion' => 'Unico diseño',
                    'precio' => 139.00,
                    'stock' => 30,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/accesorios/c1.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 4
                    'nombre' => 'Diadema de vaca',
                    'descripcion' => 'Para adulto',
                    'precio' => 59.00,
                    'stock' => 43,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/accesorios/d1.jpg']
                ],
            ];

            foreach ($productos as $productoData) {
                // Crear el producto
                $imagenes = $productoData['imagenes'];
                unset($productoData['imagenes']); // Elimina las imágenes del array de producto antes de guardar

                $producto = Producto::create($productoData);
                // Crear cada imagen asociada a este producto
                foreach ($imagenes as $imagen) {
                    Image::create([
                        'producto_id' => $producto->id,
                        'path' => $imagen,
                    ]);
                }
            }
        });
    }
}