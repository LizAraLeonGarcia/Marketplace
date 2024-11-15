<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class Producto1Seeder extends Seeder
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
                    'nombre' => 'Street Fighter Chun Li',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 599.79,
                    'stock' => 11,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/a1.jpg', 'img/productos/coleccionables/favoritas/a2.jpg', 'img/productos/coleccionables/favoritas/a3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 2
                    'nombre' => 'Street Fighter Akira',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 549.00,
                    'stock' => 20,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/b1.jpg', 'img/productos/coleccionables/favoritas/b2.jpg', 'img/productos/coleccionables/favoritas/b3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 3
                    'nombre' => 'Street Fighter Poison',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 499.00,
                    'stock' => 40,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/c1.jpg', 'img/productos/coleccionables/favoritas/c2.jpg', 'img/productos/coleccionables/favoritas/c3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 4
                    'nombre' => 'Street Fighter Rainbow Mika',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 509.00,
                    'stock' => 43,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/d1.jpg', 'img/productos/coleccionables/favoritas/d2.jpg', 'img/productos/coleccionables/favoritas/d3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 5
                    'nombre' => 'Street Fighter Menat',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 569.96,
                    'stock' => 23,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/e1.jpg', 'img/productos/coleccionables/favoritas/e2.jpg', 'img/productos/coleccionables/favoritas/e3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 6
                    'nombre' => 'Street Fighter Rose',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 469.00,
                    'stock' => 30,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/f1.jpg', 'img/productos/coleccionables/favoritas/f2.jpg', 'img/productos/coleccionables/favoritas/f3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 7
                    'nombre' => 'Street Fighter Ibuki',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 449.00,
                    'stock' => 27,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/g1.jpg', 'img/productos/coleccionables/favoritas/g2.jpg', 'img/productos/coleccionables/favoritas/g3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 8
                    'nombre' => 'Street Fighter Falke',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 589.00,
                    'stock' => 24,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/h1.jpg', 'img/productos/coleccionables/favoritas/h2.jpg', 'img/productos/coleccionables/favoritas/h3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 9
                    'nombre' => 'Street Fighter Crimson Viper',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 459.00,
                    'stock' => 33,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/i1.jpg', 'img/productos/coleccionables/favoritas/i2.jpg', 'img/productos/coleccionables/favoritas/i3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 10
                    'nombre' => 'Street Fighter Juri',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 539.00,
                    'stock' => 20,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritas/j1.jpg', 'img/productos/coleccionables/favoritas/j2.jpg', 'img/productos/coleccionables/favoritas/j3.jpg']
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
