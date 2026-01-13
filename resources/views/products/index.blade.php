@extends('layouts.public')
@section('title', 'Todos los Productos - Mi Tienda')
@push('styles')
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

</style>
@endpush

@section('content')
<div class="container mx-auto px-6 py-8">

    <!-- TÍTULO + BUSCADOR -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Texto -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Todos los Productos</h1>
            <p class="text-gray-600 mt-1">
                Encuentra los mejores productos de karate y entrena
                con la máxima comodidad y resistencia.
            </p>
        </div>

        <!-- Buscador -->
        <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..." class="w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                🔍
            </button>
        </form>
            <!--- Resultados de búsqueda -->
        @if(request()->filled('search'))
        <div class="mt-3 flex items-center gap-4 text-sm text-gray-600">
            <span>
                Resultados para
                <strong class="text-gray-900">“{{ request('search') }}”</strong>
                <span class="text-gray-500">({{ $products->count() }} resultados)</span>
            </span>

            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline transition">
                Limpiar búsqueda
            </a>
        </div>
        @endif
    </div>

    <!-- GRID DE PRODUCTOS -->
    <div class="product-grid">
        @forelse($products as $product)
        <x-product-card :product="$product" />
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No hay productos disponibles.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
