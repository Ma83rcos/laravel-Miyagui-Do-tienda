<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;

//Ruta principal (/): Muestra la página de inicio con productos y categorías destacados
Route::get('/',[WelcomeController::class, 'index'])->name('welcome');
//Prodcutos disponibles, en oferta, detalle producto, CRUD completo
Route::resource('products', ProductController::class);
Route::get('/products-on-sale',[ProductController::class, 'onSale'])->name('products.on-sale');

//Categorias lista
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

//Ofertas lista
Route::resource('offers', OfferController::class)->only(['index', 'show']);

//Carrito ver y gestionar carrito
Route::resource('cart', CartController::class);
// Página de contacto (mostrar formulario o mensaje en construcción)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
