<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'fecha',
    'hora',
    'obs',
    'orden',
    'estado',
    'user_id',
    'user_id2',
    'formulario_id',
    'proceso_id',
    ];


    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user2(){
        return $this->belongsTo(User::class,'user_id2');
    }

    public function formulario(){
        return $this->belongsTo(Formulario::class,'formulario_id');
    }

    public function proceso(){
        return $this->belongsTo(Proceso::class)->with('profiles');
    }

}
