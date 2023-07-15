<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    public $table = 'categories';
    public $timestamps = false;
    public $primaryKey = 'category_id';
}
