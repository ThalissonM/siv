<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelosVeiculos extends Model
{
    use HasFactory;
    protected $fillable = ['image','modelo'];
}
