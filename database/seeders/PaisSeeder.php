<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;

class PaisSeeder extends Seeder
{
    public function run()
    {
        $paises = [
            'Alemania',
            'Argentina',
            'Australia',
            'Austria',
            'Bélgica',
            'Belice',
            'Bolivia',
            'Brasil',
            'Canadá',
            'Chile',
            'China',
            'Corea del Sur',
            'Costa Rica',
            'Dinamarca',
            'Ecuador',
            'Egipto',
            'El Salvador',
            'España',
            'Estados Unidos',
            'Finlandia',
            'Francia',
            'Grecia',
            'Guatemala',
            'Honduras',
            'Hungría',
            'India',
            'Irlanda',
            'Italia',
            'Jamaica',
            'Japón',
            'Kenia',
            'México',
            'Nicaragua',
            'Noruega',
            'Nueva Zelanda',
            'Países Bajos',
            'Panamá',
            'Paraguay',
            'Perú',
            'Portugal',
            'Reino Unido',
            'República Checa',
            'Rusia',
            'Sudáfrica',
            'Suecia',
            'Suiza',
            'Tailandia',
            'Trinidad y Tobago',
            'Turquía',
            'Uruguay',
            'Venezuela',
        ];

        foreach ($paises as $nombre) {
            Pais::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
