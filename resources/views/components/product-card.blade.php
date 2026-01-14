<div class="bg-white rounded-lg shadow-lg overflow-hidden product-card {{ $class }} relative {{ $product->offer ? 'ring-2 ring-orange-400' : '' }} flex flex-col">

    <!-- BADGE DE OFERTA -->
    @if($product->offer)
        <div class="absolute top-0 right-0 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-bl-lg font-bold shadow-lg z-10">
            <span class="text-lg">-{{ $product->offer->discount_percentage }}%</span>
        </div>
    @endif

    <!-- IMAGEN -->
    <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden {{ $product->offer ? 'bg-gradient-to-br from-orange-50 to-red-50' : '' }}">
        @if(!empty($product->image))
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover">
        @else
            <span class="text-4xl">📦</span>
        @endif
    </div>

    <!-- DETALLES -->
    <div class="p-6 flex flex-col flex-1">
        <h4 class="text-xl font-bold mb-2 text-gray-900">{{ $product->name }}</h4>
        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 80) }}</p>

        @if($product->offer)
            <div class="mb-4">
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-semibold">
                    🏷️ {{ $product->offer->name }}
                </span>
            </div>
        @endif

        <div class="mb-4">
            @if($product->offer)
                <div class="flex items-baseline gap-2">
                    <span class="text-sm text-gray-400 line-through">€{{ number_format($product->price, 2) }}</span>
                    <span class="text-2xl font-bold text-orange-600">€{{ number_format($product->final_price, 2) }}</span>
                </div>
            @else
                <span class="text-2xl font-bold text-primary-600">€{{ number_format($product->final_price, 2) }}</span>
            @endif
        </div>

        <!-- BOTONES (alineados al fondo) -->
        <div class="flex items-center space-x-4 mt-auto">

            <!-- Ver Detalles -->
            <a href="{{ route('products.show', $product->id) }}" 
               class="flex-1 text-center bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Ver Detalles
            </a>

            <!-- Favorito -->
            @php
                $wishlistIds = auth()->check() ? auth()->user()->wishlist->pluck('id')->toArray() : session('wishlist', []);
                $isFavorite = in_array($product->id, $wishlistIds);
            @endphp
            @if(!auth()->check() || !auth()->user()->isAdmin())
                <form action="{{ $isFavorite ? route('favorites.destroy', $product->id) : route('favorites.store', $product->id) }}" method="POST">
                    @csrf
                    @if($isFavorite)
                        @method('DELETE')
                    @endif
                    <button type="submit" 
                            title="{{ $isFavorite ? 'Eliminar de favoritos' : 'Añadir a favoritos' }}"
                            class="flex items-center justify-center w-10 h-10 rounded-lg border transition hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                             fill="{{ $isFavorite ? '#dc2626' : 'none' }}" 
                             stroke="{{ $isFavorite ? '#dc2626' : '#9ca3af' }}" 
                             class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
