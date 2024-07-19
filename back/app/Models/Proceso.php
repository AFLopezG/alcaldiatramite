<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;
    protected $fillable = [
       'nombre',
       'descripcion',
       'esfuerzo',
       'dias',
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }

    public function tramites(){
        return $this->belongsToMany(Tramite::class)->withPivot('orden');
    }

    public function proceso_tramite()
    {
        return $this->belongsToMany(Tramite::class, 'proceso_tramite');
    }
}
