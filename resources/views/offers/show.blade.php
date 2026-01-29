@extends('layouts.public')
@section('title', $offer->name . ' - Miyagui-Do')

@section('content')
<div class="container mx-auto px-6 py-8">

    <!-- Header de la oferta con color dinámico -->
    <div @class([
        'rounded-lg shadow-lg p-8 mb-8 text-white flex items-center justify-between',
        'bg-gradient-to-r from-green-300 to-green-500' => strtolower($offer->name) === 'descuento primavera',
        'bg-gradient-to-r from-blue-300 to-blue-500'  => strtolower($offer->name) === 'oferta verano',
        'bg-black'                                   => strtolower($offer->name) === 'black friday',
        'bg-orange-500'                              => !in_array(strtolower($offer->name), ['descuento primavera','oferta verano','black friday']),
    ])>
        <div>
            <h1 class="text-4xl font-bold mb-2">{{ $offer->name }}</h1>
            <p class="text-xl">{{ $offer->description }}</p>
        </div>

        <!-- Porcentaje siempre en rojo -->
        <div class="bg-white text-red-600 rounded-full w-32 h-32 flex items-center justify-center">
            <div class="text-center">
                <div class="text-4xl font-bold">{{ $offer->discount_percentage }}%</div>
                <div class="text-sm">OFF</div>
            </div>
        </div>
    </div>

    <!-- Productos con esta oferta -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Productos en Oferta</h2>

        @if($offerProducts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($offerProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-100 rounded-lg">
                <p class="text-gray-500 text-lg">No hay productos con esta oferta actualmente.</p>
            </div>
        @endif
    </div>

    <!-- Botón volver a ofertas -->
    <div class="mt-8">
        <a href="{{ route('offers.index') }}" 
           class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
            Volver a Ofertas
        </a>
    </div>

</div>
@endsection
