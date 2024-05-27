<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'estado',
        'unit_id'
    ];


    public function requisitos(){
        return $this->hasMany(Requisito::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function procesos(){
        return $this->hasMany(Proceso::class);
    }
}
