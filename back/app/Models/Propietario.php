<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Propietario extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'cedula',
        'complemento',
        'nombre',
        'apellido',
    ];

    public function formularios(){
        return $this->hasMany(Formulario::class)->with('tramite')->whereNull('deleted_at');
    }
}
