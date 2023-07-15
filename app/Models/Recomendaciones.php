<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendaciones extends Model
{
    use HasFactory;
    public $table = 'recomendaciones';
    public $fillable = ['planalimentacion_id', 'tipo', 'recomendacion'];
    public $timestamps = false;
}
