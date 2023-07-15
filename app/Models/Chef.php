<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'chef_id';
}
