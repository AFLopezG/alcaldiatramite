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
            //

            //
            //["nombre"=>"VENTANILLA","unit_id"=>34],
            ["nombre"=>"VENTANILLA UNICA"],
            ["nombre"=>"JEFATURA CATASTRO URBANO"],
            ["nombre"=>"CATASTRO TRIBUTARIO"],
            ["nombre"=>"COORDINADOR"],
            ["nombre"=>"UNIDAD DRENAJE URBANO"],
            ["nombre"=>"LIQUIDACION"],
            ["nombre"=>"CODIFICACION"],
            ["nombre"=>"TOPOGRAFO"],
            ["nombre"=>"PADRON"],
            ["nombre"=>"CERTIFICACION"],
            ["nombre"=>"LEGALIZACION"],
            ["nombre"=>"SECRETARIA"],
            ["nombre"=>"ASESOR LEGAL"],

            //["nombre"=>"AREA LEGAL","unit_id"=>34],
            ["nombre"=>"JEFATURA CONTROL URBANO"],
            ["nombre"=>"RESPONSABLE SANITARIO Y ESTRUCTURAL"],      
            ["nombre"=>"RESPONSABLE DE PLANOS DE INGENIERIA"],
            ["nombre"=>"ASISTENTE DE JEFATURA"],
        ]);
    }
}
