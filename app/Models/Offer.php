<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Offer extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
    ];
    //Obtener productos en oferta
    public function products(){
        return $this->hasMany(Product::class);
    }
}
