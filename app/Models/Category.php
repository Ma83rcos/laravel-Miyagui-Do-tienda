<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model{
   use HasFactory; 

protected $fillable = [
    'name',
    'slug',
    'description',
];
    //Obtener los productos de la categoría
    public function products(){
        return $thist->hasMany(Product::class);
    }
}
