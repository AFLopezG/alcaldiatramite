<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('cargos')->insert([
            ["nombre"=>"ADMINISTRADOR"],
            ["nombre"=>"VENTANILLA UNICA"],
            ["nombre"=>"ASESOR LEGAL"],
            ["nombre"=>"ARQUITECTO"],
            ["nombre"=>"INGENIERO"],
            ["nombre"=>"CONTROL URBANO"],
            ["nombre"=>"COORDINADOR"],
            ["nombre"=>"SECRETARIA MUNICIPAL DE GESTION TERRITORIAL"],
            ["nombre"=>"DIRECCION DE ORDENAMIENTO TERRITORIAL"],
        ]);
    }
}
