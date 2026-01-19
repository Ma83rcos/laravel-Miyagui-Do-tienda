@extends('layouts.public')
@section('title', 'Categorías Miyagui-Do')
@section('content')
<div class="container mx-auto px-6 py-8">
<div class="mb-8">
<h1 class="text-3xl font-bold text-gray-900 mb-4">Categorías</h1>
<p class="text-gray-600">Categorías que inspiran tu entrenamiento.</p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-5 gap-6 justify-items-center">
@forelse($categories as $category)
<x-category-card :category="$category" />
@empty
<div class="col-span-full text-center py-12">
<p class="text-gray-500 text-lg">No hay categorías
disponibles.</p>
</div>
@endforelse
</div>
</div>
@endsection