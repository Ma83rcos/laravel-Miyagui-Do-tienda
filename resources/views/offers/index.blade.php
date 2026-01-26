@extends('layouts.public')
@section('title', 'Ofertas Miyagui-Do')
@section('content')
<div class="container mx-auto px-6 py-8">

    <!-- Título y descripción -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Ofertas Especiales</h1>
        <p class="text-gray-600">Aprovecha nuestras mejores ofertas del momento.</p>
    </div>

    <!-- Grid de ofertas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($offers as $offer)
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-red-600 flex flex-col">
            
            <!-- Contenido de la oferta -->
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $offer->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $offer->description }}</p>
                <div class="text-2xl font-bold text-red-600 mb-4">
                    {{ $offer->discount_percentage }}% de descuento
                </div>
            </div>

            <!-- Botón alineado abajo -->
            <a href="{{ route('offers.show', $offer->id) }}" 
               class="mt-auto bg-primary text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-center">
                Ver Productos
            </a>

        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No hay ofertas disponibles.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
