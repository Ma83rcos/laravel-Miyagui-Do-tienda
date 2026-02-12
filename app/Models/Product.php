<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use App\Models\Offer;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category_id',
        'offer_id',
        'stock',
    ];

    /**
     * Casts de atributos
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Relación con categoría
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación con oferta
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Relación con usuarios (carrito)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Precio final aplicando descuento si existe
     */
    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->offer && $this->offer->discount_percentage) {
                    $discount = ($this->price * $this->offer->discount_percentage) / 100;
                    return round($this->price - $discount, 2);
                }

                return $this->price;
            }
        );
    }
    /**
     * Relaciones colores y tallas
     */
    public function variants()
    {
    return $this->hasMany(ProductVariant::class);
    }

    /**
     * ¿Hay stock disponible?
     */
    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * ¿Hay stock suficiente para una cantidad concreta?
     */
    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }
}
