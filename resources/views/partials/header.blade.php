<!-- Header con navegación, Carrito de Compras y Favoritos -->
<header class="bg-white shadow-lg relative">
    <div class="container mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold text-primary-600 whitespace-nowrap">
            🥋 Tienda Miyagui-Do
            </a>
        </div>

        <!-- Navegación de escritorio -->
        <div class="hidden md:flex space-x-6">
            @include('partials.navigation') <!-- tu menú de escritorio -->
        </div>

        <!-- Carrito y Favoritos + Hamburger -->
        @php
            $cart = session('cart', []);
            $totalQuantity = array_sum(array_column($cart, 'quantity'));

            $showWishlist = !auth()->check() || (auth()->check() && !auth()->user()->isAdmin());
            $wishlistCount = $showWishlist
                ? (auth()->check() ? auth()->user()->wishlist()->count() : count(session('wishlist', [])))
                : 0;
        @endphp

        <div class="flex items-center space-x-4">

            <!-- Favoritos -->
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

            <!-- Carrito -->
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

            <!-- Botón hamburguesa (solo móvil) -->
            <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none ml-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menú móvil -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
        <div class="flex flex-col p-4 space-y-2">
            <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-primary-600">Inicio</a>
            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-600">Productos</a>
            <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary-600">Categorías</a>
            <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-primary-600">Ofertas</a>
            <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-primary-600">Contacto</a>

            @guest
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600">Login</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-primary-600">Registrar</a>
                @endif
            @endguest

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-primary-600">Administrar tienda</a>
                @else
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-primary-600">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-primary-600">Cerrar sesión</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</header>

<script>
    // Toggle menú móvil
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
