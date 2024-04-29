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
            ['nombre'=>'IMPUESTO A LA TRANSFERENCIA','descripcion'=>'','unit_id'=>34,'codigo'=>'1'],
            ['nombre'=>'LEGALIZACION DE PLANO DEMOSTRATIVO','descripcion'=>'','unit_id'=>34,'codigo'=>'2'],
            ['nombre'=>'INFORME TECNICO','descripcion'=>'','unit_id'=>34,'codigo'=>'3'],
            ['nombre'=>'CERTIFICACION GENERAL C. BANCARIO','descripcion'=>'','unit_id'=>34,'codigo'=>'4'],
            ['nombre'=>'CAMBIO DE NOMBRE Y CODIFICACION','descripcion'=>'','unit_id'=>34,'codigo'=>'5'],
            ['nombre'=>'DRENAJE URBANO','descripcion'=>'','unit_id'=>34,'codigo'=>'6'],
            ['nombre'=>'RECATASTRACION','descripcion'=>'','unit_id'=>34,'codigo'=>'7'],
            ['nombre'=>'REGULACION DE IMPUESTOS','descripcion'=>'','unit_id'=>34,'codigo'=>'8'],
            ['nombre'=>'CERTIFICADO CATASTRAL','descripcion'=>'','unit_id'=>34,'codigo'=>'9'],
            ['nombre'=>'ACTUALIZACION CERTIFICADO CATASTRAL','descripcion'=>'','unit_id'=>34,'codigo'=>'10'],
           // 
            ['nombre'=>'PROCESO DE APROBACION DE PLANO DE CONSTRUCCION','descripcion'=>'','unit_id'=>28,'codigo'=>'1'],
            ['nombre'=>'PROCESO DE APROBACION DE PLANO HORIZONTAL','descripcion'=>'','unit_id'=>28,'codigo'=>'2'],
            ['nombre'=>'PROCESO DE APROBACION PLANOS DE URBANIZACION','descripcion'=>'','unit_id'=>28,'codigo'=>'3'],
            ['nombre'=>'PROCESO DE APROBACION PLANOS TOPOGRAFICOS GEO','descripcion'=>'','unit_id'=>28,'codigo'=>'4'],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE FRACCIONAMIENTO MAYORES DE 1000M2 9999m2 ','descripcion'=>'','unit_id'=>28,'codigo'=>'5'],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE FRACCIONAMIENTO SUB PROCESO','descripcion'=>'','unit_id'=>28,'codigo'=>'6'],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DE UNIFICACION','descripcion'=>'','unit_id'=>28,'codigo'=>'7'],
            ['nombre'=>'PROCESO DE APROBACION USO DE PLANOS DEMISTRATIVOS INDIVIDUALES DE URBANIZACIONES CONSOLIDADAS','descripcion'=>'','unit_id'=>28,'codigo'=>'8'],
            ['nombre'=>'PROCESO DE APROBACION USO DE SUELOS','descripcion'=>'','unit_id'=>28,'codigo'=>'9'],
            ['nombre'=>'PROCESO DE AUTORIZACION LINEA NIVEL','descripcion'=>'','unit_id'=>28,'codigo'=>'10'],
            ['nombre'=>'PROCESO DE AUTORIZACION OBRAS CIVILES MENORES','descripcion'=>'','unit_id'=>28,'codigo'=>'11'],
        ]);

    }
}
