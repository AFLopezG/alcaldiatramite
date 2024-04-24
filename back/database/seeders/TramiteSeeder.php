<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tramites')->insert([
            ['nombre'=>'PROCESO DE APROBACION DE PLANO DE CONSTRUCCION','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION DE PLANO HORIZONTAL','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION PLANOS DE URBANIZACION','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION PLANOS TOPOGRAFICOS GEO','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE FRACCIONAMIENTO MAYORES DE 1000M2 9999m2 ','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE FRACCIONAMIENTO SUB PROCESO','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE UNIFICACION','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DEMISTRATIVOS INDIVIDUALES DE URBANIZACIONES CONSOLIDADAS','descripcion'=>''],
            ['nombre'=>'PROCESO DE APROBACION USO DE SUELOS','descripcion'=>''],
            ['nombre'=>'PROCESO DE AUTORIZACION LINEA NIVEL','descripcion'=>''],
            ['nombre'=>'PROCESO DE AUTORIZACION OBRAS CIVILES MENORES','descripcion'=>''],
        ]);

    }
}
