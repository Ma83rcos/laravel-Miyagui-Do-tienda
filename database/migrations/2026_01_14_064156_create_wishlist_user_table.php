<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wishlist_user', function (Blueprint $table) {
            $table->id();
            
            // Usuario que agrega el favorito
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Producto favorito
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            // Evitar duplicados (usuario no puede marcar el mismo producto dos veces)
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist_user');
    }
};
