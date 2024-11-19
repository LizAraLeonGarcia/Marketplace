<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class Producto2Seeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Obtener el usuario vendedor por su correo
            $user = User::where('email', 'rusherforever777@gmail.com')->first();

            if (!$user) {
                $this->command->info("No se encontró un usuario con el correo 'rusherforever777@gmail.com'.");
                return;
            }
            // Obtener el ID de la categoría 'Coleccionables' por su nombre
            $categoria = Categoria::where('nombre', 'Coleccionables')->first();

            if (!$categoria) {
                $this->command->info("No se encontró la categoría 'Coleccionables'. Asegúrate de tener esa categoría en la base de datos.");
                return;
            }
            // Crear productos para el usuario en la categoría 'Coleccionables'
            $productos = [
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 1
                    'nombre' => 'Street Fighter E. Honda',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 549.79,
                    'stock' => 19,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/a1.jpg', 'img/productos/coleccionables/familia/a2.jpg', 'img/productos/coleccionables/familia/a3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 2
                    'nombre' => 'Street Fighter Dhalsim',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 519.00,
                    'stock' => 28,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/b1.jpg', 'img/productos/coleccionables/familia/b2.jpg', 'img/productos/coleccionables/familia/b3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 3
                    'nombre' => 'Street Fighter Dee Jay',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 479.00,
                    'stock' => 30,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/c1.jpg', 'img/productos/coleccionables/familia/c2.jpg', 'img/productos/coleccionables/familia/c3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 4
                    'nombre' => 'Street Fighter Rainbow Guile',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 529.00,
                    'stock' => 33,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/d1.jpg', 'img/productos/coleccionables/familia/d2.jpg', 'img/productos/coleccionables/familia/d3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 5
                    'nombre' => 'Street Fighter Cammy',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 589.96,
                    'stock' => 27,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/e1.jpg', 'img/productos/coleccionables/familia/e2.jpg', 'img/productos/coleccionables/familia/e3.jpg']
                ],
                [ // ----------------------------------------------------------------------------------------------------------------- PRODUCTO 6
                    'nombre' => 'Street Fighter Abigail',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 569.00,
                    'stock' => 39,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/familia/f1.jpg', 'img/productos/coleccionables/familia/f2.jpg', 'img/productos/coleccionables/familia/f3.jpg']
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