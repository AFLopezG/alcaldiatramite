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
    'user_id',
    'user_id2',
    'formulario_id',
    'cargo_id',
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
        return $this->belongsTo(User::class,'user_id2')->with('cargo');
    }

    public function formulario(){
        return $this->belongsTo(Formulario::class,'formulario_id');
    }

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }
}
