<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permisos')->insert([
            ["nombre"=>"GESTION USUARIOS"],
            ["nombre"=>"REGISTRO DE TRAMITE"],
            ["nombre"=>"ASIGNACIONES"],
            ["nombre"=>"SEGUIMIENTO TRAMITE"],
            ["nombre"=>"ELIMINAR TRAMITE"],
            ["nombre"=>"REPORTE ANUAL"],
            ["nombre"=>"MODIFICAR ASIGNACION"],
        ]);

        DB::table('permiso_user')->insert([
            ['permiso_id'=>1,'user_id'=>1],
            ['permiso_id'=>2,'user_id'=>1],
            ['permiso_id'=>3,'user_id'=>1],
            ['permiso_id'=>4,'user_id'=>1],
            ['permiso_id'=>5,'user_id'=>1],
            ['permiso_id'=>6,'user_id'=>1],
            ['permiso_id'=>7,'user_id'=>1],
        ]);

    }
}
