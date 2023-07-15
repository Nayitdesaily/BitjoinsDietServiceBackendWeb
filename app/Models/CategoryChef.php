<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryChef extends Model
{
    use HasFactory;
    public $table = 'category_chef';
    public $primaryKey = 'category_id';
}
