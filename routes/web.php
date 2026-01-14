<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===========================================
// RUTAS PÚBLICAS (Sin autenticación requerida)
// ===========================================

// Welcome page - shows home page with featured content
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Contact page
    // Página de contacto (formulario)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
   // Enviar mensaje del formulario
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Rutas de categorías (solo lectura)
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// Rutas de productos (solo lectura)
Route::get('/products-on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Rutas de ofertas (solo lectura)
Route::resource('offers', OfferController::class)->only(['index', 'show']);

// Rutas del carrito de compras (invitados + usuarios)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// ===========================================
// Favoritos (Lista de deseos, invitados + usuarios)
// ===========================================
Route::prefix('favorites')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('favorites.index');
    Route::post('/{id}', [WishlistController::class, 'store'])->name('favorites.store');
    Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('favorites.destroy');
});

// ===========================================
// RUTAS DE USUARIO AUTENTICADO (Breeze)
// ===========================================

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ===========================================
// RUTAS DE ADMINISTRACIÓN (Protegidas + Loogin)
// ===========================================

Route::middleware('auth', 'admin', 'log.activity')->prefix('admin')->name('admin.')->group(function () {
    // Rutas de gestión de productos
     // Index de productos (ruta manual)
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
});

// Las rutas de autenticación (login, register, etc.) se incluyen desde aquí
require __DIR__.'/auth.php';