<!-- Header con navegación, Carrito de Compras y Favoritos -->
<header class="bg-white shadow-lg relative">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('welcome') }}" class="text-2xl font-bold text-primary-600">
                    🥋 Tienda Miyagui-Do
                </a>
            </div>

            <!-- Navegación usando partial -->
            @include('partials.navigation')

            <!-- Carrito y Favoritos -->
            @php
                // Carrito
                $cart = session('cart', []);
                $totalQuantity = array_sum(array_column($cart, 'quantity'));

                // Decidir si mostrar favoritos
                $showWishlist = !auth()->check() || (auth()->check() && !auth()->user()->isAdmin());

                // Cantidad de favoritos solo si se va a mostrar
                $wishlistCount = $showWishlist
                    ? (auth()->check() ? auth()->user()->wishlist()->count() : count(session('wishlist', [])))
                    : 0;
            @endphp

            <div class="flex items-center space-x-4">

                <!-- Botón Favoritos (solo si $showWishlist es true) -->
                @if($showWishlist)
                    <a href="{{ route('favorites.index') }}" 
                       class="relative flex items-center justify-center w-10 h-10 transition-transform hover:scale-110"
                       title="Mis Favoritos">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                             fill="{{ $wishlistCount > 0 ? '#dc2626' : 'none' }}" 
                             stroke="{{ $wishlistCount > 0 ? '#dc2626' : '#9ca3af' }}" 
                             class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                        </svg>

                        @if($wishlistCount > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold rounded-full px-2">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <!-- Botón Carrito (siempre visible) -->
                <a href="{{ route('cart.index') }}" 
                   class="relative flex items-center justify-center w-10 h-10 transition-transform hover:scale-110"
                   title="Mi Carrito">
                    <span class="text-2xl">🛒</span>

                    @if($totalQuantity > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold rounded-full px-2">
                            {{ $totalQuantity }}
                        </span>
                    @endif
                </a>

            </div>
        </div>
    </div>
</header>
