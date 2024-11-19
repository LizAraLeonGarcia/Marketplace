<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class Producto4Seeder extends Seeder
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
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 12
                    'nombre' => 'Street Fighter Blanka',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 429.29,
                    'stock' => 32,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/l1.jpg', 'img/productos/coleccionables/favoritos/l2.jpg', 'img/productos/coleccionables/favoritos/l3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 13
                    'nombre' => 'Street Fighter M. Bison',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 399.00,
                    'stock' => 37,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/m1.jpg', 'img/productos/coleccionables/favoritos/m2.jpg', 'img/productos/coleccionables/favoritos/m3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 14
                    'nombre' => 'Street Fighter Oni',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 445.15,
                    'stock' => 29,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/n1.jpg', 'img/productos/coleccionables/favoritos/n2.jpg', 'img/productos/coleccionables/favoritos/n3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 15
                    'nombre' => 'Street Fighter Dudley',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 449.00,
                    'stock' => 26,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/ñ1.jpg', 'img/productos/coleccionables/favoritos/ñ2.jpg', 'img/productos/coleccionables/favoritos/ñ3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 16
                    'nombre' => 'Street Fighter Adon',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 379.60,
                    'stock' => 24,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/o1.jpg', 'img/productos/coleccionables/favoritos/o2.jpg', 'img/productos/coleccionables/favoritos/o3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 17
                    'nombre' => 'Street Fighter Akuma',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 450.00,
                    'stock' => 35,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/p1.jpg', 'img/productos/coleccionables/favoritos/p2.jpg', 'img/productos/coleccionables/favoritos/p3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 18
                    'nombre' => 'Street Fighter G',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 475.00,
                    'stock' => 25,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/q1.jpg', 'img/productos/coleccionables/favoritos/q2.jpg', 'img/productos/coleccionables/favoritos/q3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 19
                    'nombre' => 'Street Fighter Alex',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 409.26,
                    'stock' => 32,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/r1.jpg', 'img/productos/coleccionables/favoritos/r2.jpg', 'img/productos/coleccionables/favoritos/r3.jpg']
                ],
                [ // --------------------------------------------------------------------------------------------------------------- PRODUCTO 20
                    'nombre' => 'Street Fighter Ken',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 399.00,
                    'stock' => 40,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/s1.jpg', 'img/productos/coleccionables/favoritos/s2.jpg', 'img/productos/coleccionables/favoritos/s3.jpg']
                ],
                [ // ---------------------------------------------------------------------------------------------------------------- PRODUCTO 21
                    'nombre' => 'Street Fighter Evil Ryu',
                    'descripcion' => 'Revista + estatuilla, nueva y sellada',
                    'precio' => 450.00,
                    'stock' => 38,
                    'categoria_id' => $categoria->id,
                    'user_id' => $user->id,
                    'imagenes' => ['img/productos/coleccionables/favoritos/t1.jpg', 'img/productos/coleccionables/favoritos/t2.jpg', 'img/productos/coleccionables/favoritos/t3.jpg']
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
