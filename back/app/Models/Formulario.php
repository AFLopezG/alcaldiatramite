<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'numero',
    'gestion',
    'codigo',
    'direccion',
    'distrito',
    'observacion',
    'habilita',
    'gestorci',
    'gestornom',
    'estado',
    'fecha',
    'hora',
    'tramite_id',
    'propietario_id',
    'user_id',
    'cargo_id',
    ];

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class)->with('requisitos')->with('unit');
    }

    public function propietario(){
        return $this->belongsTo(Propietario::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function logs(){
        return $this->hasMany(Log::class)->with('user')->with('user2')->with('cargo');
    }
}
