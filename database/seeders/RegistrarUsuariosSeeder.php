<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegistrarUsuariosSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Crear un conjunto de usuarios
            $usuarios = [
                [   // ---------------------------------------------------------------------------------------------------------------- USUARIO 1
                    'name' => 'Lizbeth',
                    'email' => 'rusherforever777@gmail.com',
                    'password' => '123456789',  
                ],
                [   // ---------------------------------------------------------------------------------------------------------------- USUARIO 2
                    'name' => 'Araceli',
                    'email' => 'b.armyforever333@gmail.com',
                    'password' => '123456789',
                ],
            ];

            foreach ($usuarios as $usuarioData) {
                // Crear el usuario con el hash de la contraseña
                $usuarioData['password'] = Hash::make($usuarioData['password']); // Hashear la contraseña antes de guardarla
                User::create($usuarioData);
            }
        });
    }
}
