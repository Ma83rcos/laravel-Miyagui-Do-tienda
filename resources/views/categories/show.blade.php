@extends('layouts.public')
@section('title', $category->name . ' - Miyagui-Do')
@section('content')

<div class="container mx-auto px-6 py-8">

    {{-- Breadcrumbs --}}
    <nav class="text-sm mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1">
            <li>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                <span class="mx-2 text-gray-400">/</span>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700">Categorías</a>
                <span class="mx-2 text-gray-400">/</span>
            </li>
            <li class="text-gray-900 font-semibold">{{ $category->name }}</li>
        </ol>
    </nav>

    {{-- Encabezado de categoría --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
            @endif
        </div>

        {{-- Botón profesional de volver --}}
        <a href="{{ route('categories.index') }}"
           class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-700 border border-primary-200 rounded-lg hover:bg-primary-100 hover:text-primary-800 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a Categorías
        </a>
    </div>

    {{-- Grid de productos --}}
    @if($categoryProducts->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categoryProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No hay productos en esta categoría.</p>
    </div>
    @endif

</div>

@endsection
