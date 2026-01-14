<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Product;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wishlist() {
    return $this->belongsToMany(Product::class, 'wishlist_user')
                ->withTimestamps();
    }


    public function isAdmin()
    {
    return $this->role === 'admin';
    }

    //Obtener los productos en el carrito del usuario (relación N:M)
    public function products(){
        return $this->belongsToMany(Product::class, 'product_user')
        ->withPivot('quantity')
        ->withTimestamps();
    }
}
