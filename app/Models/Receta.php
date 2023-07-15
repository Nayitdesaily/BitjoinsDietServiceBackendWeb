<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = "recipes";
    public $primaryKey = "recipe_id";
}
