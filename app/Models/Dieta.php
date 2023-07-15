<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    use HasFactory;
    public $table = 'dieta';
    public $timestamps = false;
    public $fillable = ['planalimentacion_id', 'opcion', 'comida', 'label', 'descripcion', 'oplabel', 'fecha_inicio'];
}
