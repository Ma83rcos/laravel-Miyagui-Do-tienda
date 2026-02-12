{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title', 'Administrador 🥋Miyagui-Do') </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    {{-- Barra superior --}}
   <header x-data="{ open: false }" class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Nombre tienda --}}
            <div class="text-2xl font-bold text-gray-800">
                🥋 Miyagui-Do
            </div>

            {{-- Navegación desktop --}}
            <nav class="hidden sm:flex space-x-4">
                <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-primary-600 transition">
                    🏪 Tienda
                </a>
                <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-primary-600 transition">
                    Productos
                </a>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-primary-600 transition">
                    Categorías
                </a>
                <a href="{{ route('admin.offers.index') }}" class="text-gray-700 hover:text-primary-600 transition">
                    Ofertas
                </a>
            </nav>

            <div class="flex items-center space-x-4">

                {{-- Usuario (lo dejamos como lo tienes) --}}
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2">
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Hamburger móvil --}}
                <div class="sm:hidden">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100">

                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }"
                                  class="inline-flex"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />

                            <path :class="{'hidden': !open, 'inline-flex': open }"
                                  class="hidden"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div x-show="open"
         x-transition
         class="sm:hidden bg-white border-t px-4 py-3 space-y-2">

        <a href="{{ route('welcome') }}" class="block">🏪 Tienda</a>
        <a href="{{ route('admin.products.index') }}" class="block">Productos</a>
        <a href="{{ route('admin.categories.index') }}" class="block">Categorías</a>
        <a href="{{ route('admin.offers.index') }}" class="block">Ofertas</a>
    </div>
</header>

    {{-- Contenido principal --}}
    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    {{-- Script para dropdown usuario --}}
    <script>
        const button = document.getElementById('user-menu-button');
        const dropdown = document.getElementById('user-dropdown');
        button.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });
        window.addEventListener('click', (e) => {
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

    </script>
</body>
</html>
