<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    use HasFactory;
    protected $fillable = [
    'ruta',
    'nombre',
    'orden',
    'baja',
    'formulario_id',
    'proceso_id',
    ];
}
