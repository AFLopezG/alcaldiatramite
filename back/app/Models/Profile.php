<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'prof'];

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'profile_user');
    }
}
