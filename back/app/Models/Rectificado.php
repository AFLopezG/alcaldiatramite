<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rectificado extends Model
{
    use HasFactory;
    protected $fillable = [
    'inicio',
    'fin',
    'orden',
    'descripcion',
    'tramite_id',
    'proceso_id',
    'user_id',
    ];
}
