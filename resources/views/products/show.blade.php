@extends('layouts.public')
@section('title', $product->name . ' Miyagui-Do')
@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Imagen del Producto -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="h-96 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center border rounded-lg">
                @if(!empty($product->image))
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy" class="max-h-full max-w-full object-contain transition-transform duration-300 hover:scale-105">
                @else
                <span class="text-8xl" aria-hidden="true">📦</span>
                @endif
            </div>
        </div>

        <!-- Información del Producto -->
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-6">{{ $product->description }}</p>

            <!-- Precio -->
            <div class="mb-6">
                @if($product->offer)
                <div class="flex items-baseline gap-3">
                    <span class="text-2xl text-gray-400 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-4xl font-bold text-orange-600">€{{ number_format($product->final_price, 2) }}</span>
                </div>
                <p class="text-sm text-orange-600 mt-2">
                    ¡Ahorra €{{ number_format($product->price - $product->final_price, 2) }}!
                </p>
                @else
                <span class="text-4xl font-bold text-primary-600">€{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <!-- Categoría -->
            @if($product->category)
            <div class="mb-6">
                <span class="text-sm text-gray-500">Categoría:</span>
                <a href="{{ route('categories.show', $product->category->id) }}" class="ml-2 bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm hover:bg-primary-200 transition">
                    {{ $product->category->name }}
                </a>
            </div>
            @endif

            <!-- Oferta -->
            @if($product->offer)
            <div class="mb-6">
                <span class="text-sm text-gray-500">Oferta activa:</span>
                <div class="mt-2">
                    <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full">
                        🏷 {{ $product->offer->name }} (-{{ $product->offer->discount_percentage }}%)
                    </span>
                </div>
            </div>
            @endif

            <!-- ===========================
                 Botones de acción: Carrito + Favorito + Volver
                 =========================== -->
            <div class="flex items-center space-x-4 mt-auto">

                <!-- Añadir al carrito -->
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                        🛒 Añadir al Carrito
                    </button>
                </form>

                <!-- Favorito -->
                @php
                $wishlistIds = auth()->check()
                ? auth()->user()->wishlist->pluck('id')->toArray()
                : session('wishlist', []);
                $isFavorite = in_array($product->id, $wishlistIds);
                @endphp
                <form action="{{ $isFavorite ? route('favorites.destroy', $product->id) : route('favorites.store', $product->id) }}" method="POST">
                    @csrf
                    @if($isFavorite)
                    @method('DELETE')
                    @endif
                    <button type="submit" title="{{ $isFavorite ? 'Eliminar de favoritos' : 'Añadir a favoritos' }}" class="flex items-center justify-center w-12 h-12 rounded-lg border transition hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isFavorite ? '#dc2626' : 'none' }}" stroke="{{ $isFavorite ? '#dc2626' : '#9ca3af' }}" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                    </button>
                </form>

                <!-- Volver a Productos -->
                <a href="{{ route('products.index') }}" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-100 transition">
                    Volver a Productos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
