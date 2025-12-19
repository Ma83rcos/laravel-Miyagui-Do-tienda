<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'offer_id',
    ];
    //Obtener los atributos que deben ser casteados
    protected function casts(): array{
        return [
            'price' => 'decimal:2',
        ];
    }
    //Obtener la categoría a la que pertenece el producto
    public function Ctegory(): BelongsTo{
        return $this->belongsTo(Category::class);
    }
    //Obtener la oferta asociada al producto
    public function Offer() : BelongsTo{
        return $this->belongsTo(Offer::class);
    }
    //Obtener los usuarios asociados a este producto a través del carrito (relación N:M)
    public function users(){
        return $this->belongsToMany(User::class, 'product_user')
        ->withPivot('quantity')
        ->withTimestamps();
    }
    //Obtener el precio final del producto tras aplicar descuentos
    public function finalPrice(): Attribute{
    return Attribute::make(
        get: function() {
            if($this->offer && $this->offer->discount_percentage){
                $discount = ($this->price * $this->offer->discount_percentage) / 100;
                return round($this->price - $discount, 2);
            }
            return $this->price;
        },
    );
}
}
    
