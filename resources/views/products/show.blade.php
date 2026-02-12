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
                    <span class="text-4xl font-bold text-red-600">€{{ number_format($product->final_price, 2) }}</span>
                </div>
                <p class="text-sm text-red-600 mt-2">
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
                    <span class="inline-block bg-red-100 text-red-600 text-sm px-3 py-1 rounded-full">
                        🏷 {{ $product->offer->name }} (-{{ $product->offer->discount_percentage }}%)
                    </span>
                </div>
            </div>
            @endif

            <!-- ===========================
                    FORMULARIO PRODUCTO
                 =========================== -->

            @php
            $wishlistIds = auth()->check()
            ? auth()->user()->wishlist->pluck('id')->toArray()
            : session('wishlist', []);
            $isFavorite = in_array($product->id, $wishlistIds);

            // Colores únicos
            $uniqueColors = collect($variantsForBlade ?? [])->pluck('color')->unique();
            @endphp

            <form action="{{ route('cart.store') }}" method="POST" class="w-full mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- FILA 1: COLOR + TALLA --}}
                @if(!empty($variantsForBlade))
                <div class="grid grid-cols-2 gap-4 mb-4">

                    <!-- Color -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Color:
                        </label>
                        <select name="color" id="color" class="w-full h-12 rounded border border-blue-500 bg-blue-50 text-blue-900 px-3 shadow-sm focus:ring-2 focus:ring-blue-400" required>
                            @foreach($uniqueColors as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Talla -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Talla:
                        </label>
                        <select name="size" id="size" class="w-full h-12 rounded border border-blue-500 bg-blue-50 text-blue-900 px-3 shadow-sm focus:ring-2 focus:ring-blue-400" required>
                            @foreach($variantsForBlade as $variant)
                            @foreach($variant['sizes'] as $size => $stock)
                            <option value="{{ $size }}" data-color="{{ $variant['color'] }}" @if($stock==0) disabled style="color:#aaa;" @endif>
                                {{ $size }} @if($stock == 0) (Agotado) @endif
                            </option>
                            @endforeach
                            @endforeach
                        </select>
                    </div>

                </div>
                @endif

                {{-- FILA 2: LOS 3 BOTONES EN LÍNEA (SIEMPRE) --}}
                <div class="flex gap-3">

                    <!-- Añadir carrito -->
                    <button type="submit" class="flex-1 h-12 bg-primary text-white rounded-lg hover:bg-primary-700 transition font-medium text-sm">
                        🛒 Añadir Carrito
                    </button>

                    <!-- Volver -->
                    <a href="{{ route('products.index') }}" class="flex-1 h-12 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition flex items-center justify-center font-medium text-sm">
                        Volver Productos
                    </a>

                    <!-- Favorito -->
                    <button type="submit" formaction="{{ $isFavorite ? route('favorites.destroy', $product->id) : route('favorites.store', $product->id) }}" formmethod="POST" class="w-12 h-12 border rounded-lg flex items-center justify-center transition hover:bg-gray-100
            {{ $isFavorite ? 'border-red-600 text-red-600' : 'border-gray-300 text-gray-400' }}">

                        @if($isFavorite)
                        @method('DELETE')
                        @endif

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                    </button>

                </div>
            </form>

            <!-- ===========================
             Script filtro talla por color
             =========================== -->
            <script>
                const colorSelect = document.getElementById('color');
                const sizeSelect = document.getElementById('size');

                if (colorSelect && sizeSelect) {
                    colorSelect.addEventListener('change', function() {
                        const selectedColor = this.value;

                        Array.from(sizeSelect.options).forEach(opt => {
                            if (opt.dataset.color === selectedColor) {
                                opt.hidden = false;
                            } else {
                                opt.hidden = true;
                            }
                        });

                        sizeSelect.selectedIndex = 0;
                    });

                    // Forzar filtrado al cargar
                    colorSelect.dispatchEvent(new Event('change'));
                }

            </script>


        </div>
    </div>
</div>
@endsection
