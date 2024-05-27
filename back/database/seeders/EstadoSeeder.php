<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('estados')->insert([
            ["nombre"=>"En proceso"],
            ["nombre"=>"Derivado"],
            ["nombre"=>"Rechazado"],
            ["nombre"=>"Finalizado"],
            ["nombre"=>"Cancelado"],
            ["nombre"=>"Con retrazo"],
            ["nombre"=>"Rectificacion"],
        ]);
    }
}
