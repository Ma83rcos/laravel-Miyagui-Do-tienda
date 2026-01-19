@props(['category'])

<a href="{{ route('categories.show', $category->id) }}"
   class="block relative bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden category-card w-full max-w-xs flex flex-col">

    {{-- Imagen de la categoría --}}
    <div class="h-56 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center border-b overflow-hidden">
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" 
                 alt="{{ $category->name }}" 
                 loading="lazy" 
                 class="max-h-full max-w-full object-contain p-4 transition-transform duration-300 hover:scale-105">
        @else
            <span class="text-5xl" aria-hidden="true">📦</span>
        @endif
    </div>

    {{-- Detalles de la categoría --}}
    <div class="p-6 flex flex-col flex-1">
        <h4 class="text-xl font-bold mb-2 text-gray-900 text-center">
            {{ $category->name }}
        </h4>

        <p class="text-gray-600 text-sm text-center leading-relaxed">
            {{ $category->description }}
        </p>
    </div>
</a>
