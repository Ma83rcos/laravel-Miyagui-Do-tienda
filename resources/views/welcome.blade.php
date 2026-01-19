@extends('layouts.public')
@section('title', '🥋Miyagui-Do Online')
@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

</style>
@endpush
@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center py-24"
    style="background-image:
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
        url('{{ asset('storage/HeroInicio.png') }}');">

    <div class="container mx-auto px-6 text-center text-white">

        <!-- ETIQUETA DE OFERTA -->
        <a href="{{ route('products.on-sale') }}"
           class="inline-block mb-6 px-4 py-1 text-sm font-semibold uppercase tracking-widest
                  bg-red-600 text-white rounded-md hover:bg-red-700 transition">
            🔥 Ofertas especiales
        </a>

        <h2 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
            Bienvenido a Miyagui-Do
        </h2>

        <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto text-gray-200">
            Disciplina, respeto y superación en cada producto.
        </p>

        <!-- BOTÓN PRINCIPAL -->
        <a href="{{ route('products.index') }}"
           class="inline-block bg-white text-gray-900 font-bold py-4 px-10
                  uppercase tracking-wide border-2 border-white
                  hover:bg-transparent hover:text-white transition">
            Entrar a la tienda
        </a>

    </div>
</section>


<!-- Categorías Destacadas -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold mb-12 text-center text-gray-900">
            Nuestras Categorías
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
            @forelse($featuredCategories as $category)
            <x-category-card :category="$category" />
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No hay categorías disponibles.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Productos Destacados -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold mb-12 text-center text-gray-900">
            Productos Destacados
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
            <x-product-card :product="$product" />
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No hay productos
                    destacados.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
