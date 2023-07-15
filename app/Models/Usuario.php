<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasApiTokens, HasFactory;
    public $table = 'usuario';
    public $timestamps = false;


    // protected $hidden = ['pass'];

    protected $fillable = [
        'tipousuario_id',
        'email',
        'pass',
        'persona_id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
