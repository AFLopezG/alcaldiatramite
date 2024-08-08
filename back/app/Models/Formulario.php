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
    'codtram',
    'detalle',
    'distrito',
    'observacion',
    'gestorci',
    'gestornom',
    'estado',
    'fecha',
    'hora',
    'tramite_id',
    'propietario_id',
    'user_id',
    'unit_id',
    'delegado_id'
    ];

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    public function tramite(){
        return $this->belongsTo(Tramite::class)->with('requisitos')->with('unit');
    }

    public function tramite2(){
        return $this->belongsTo(Tramite::class)->with('procesos');
    }

    public function propietario(){
        return $this->belongsTo(Propietario::class);
    }

    public function delegado(){
        return $this->belongsTo(Delegado::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function logs(){
        return $this->hasMany(Log::class)->with('user')->with('user2')->with('proceso');
    }

    public function rectificados(){
        return $this->hasMany(Rectificado::class)->orderBy('id','desc');
    }

    public function latestLog()
    {
        return $this->hasOne(Log::class)->with('user2')->with('proceso')->latestOfMany();
    }

}
