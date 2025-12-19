<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illumintae\Database\Eloquent\Relations\HasMany;


class Offer extends Model{
    use HasFactory;

    protected $fillable = [
        'title',
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
