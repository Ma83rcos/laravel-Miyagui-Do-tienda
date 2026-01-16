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
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            {{-- Nombre tienda --}}
            <div class="text-2xl font-bold text-gray-800">
                🥋 Miyagui-Do Online
            </div>

            {{-- Navegación admin --}}
            <nav class="flex space-x-4">
                <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-primary-600 transition">
                    🏪 Tienda
                </a>
                <a href="{{ route('admin.products.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('admin.products.*') ? 'text-primary-600 font-semibold' : '' }}">
                    Productos
                </a>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('admin.categories.*') ? 'text-primary-600 font-semibold' : '' }}">
                    Categorías
                </a>
                <a href="{{ route('admin.offers.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('admin.offers.*') ? 'text-primary-600 font-semibold' : '' }}">
                    Ofertas
                </a>
            </nav>

            {{-- Usuario --}}
            <div class="relative">
                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                    <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown usuario --}}
                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2">
                    <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
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

