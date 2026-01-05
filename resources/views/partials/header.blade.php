@php
    // Obtener el usuario autenticado, o el usuario por defecto (id=1)
    $user = auth()->user() ?? App\Models\User::find(1);

    // Sumar las cantidades de todos los productos en el carrito
    // Se lee directamente de la tabla pivot 'product_user'
    $cartCount = $user->products()->sum('product_user.quantity');
@endphp

<!-- Header con navegación -->
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

            <!-- Carrito -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}"
                   class="text-gray-700 hover:text-primary-600 transition relative">
                    🛒 Carrito 
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-6 
                                     bg-red-500 text-white text-xs font-bold 
                                     rounded-full px-2">
                            {{ $cartCount }} <!-- Número total de items -->
                        </span>
                    @endif            
                </a>
            </div>

        </div>
    </div>
</header>
