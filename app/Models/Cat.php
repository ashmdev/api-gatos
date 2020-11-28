<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;
    //nombre de la tabla
    protected $table = "saved_cats";

    //campos de asignación masiva
    protected $fillable = [
        'name',
        'description',
        'image',
    ];
}
