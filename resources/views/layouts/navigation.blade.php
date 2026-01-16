@php
// Mostrar wishlist solo para invitados o usuarios que NO son admin
$showWishlist = !auth()->check() || (auth()->check() && !auth()->user()->isAdmin());

// Contar los items de wishlist solo si se va a mostrar
$wishlistCount = $showWishlist
? (auth()->check() ? auth()->user()->wishlist->count() : count(session('wishlist', [])))
: 0;
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                <!-- Tienda -->
                <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                    {{ __('Tienda') }}
                </x-nav-link>

                <!-- Administración (solo admins) -->
                @if(auth()->check() && auth()->user()->isAdmin())
                <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                    {{ __('Productos') }}
                </x-nav-link>
                @endif

                <!-- Lista de deseos (usuarios o invitados, NO admins) -->
                @if($showWishlist)
                <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index*')">
                    ❤️ Lista de Deseos
                    @if($wishlistCount > 0)
                    <span class="ml-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $wishlistCount }}
                    </span>
                    @endif
                </x-nav-link>
                @endif
            </div>

            <!-- Settings Dropdown (solo usuarios autenticados) -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Mostrar enlace Perfil solo si NO estamos en la página de perfil --}}
                        @if(!request()->routeIs('profile.edit'))
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>
                        @endif

                        {{-- Cerrar sesión siempre disponible --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth


            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <!-- Tienda -->
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                {{ __('Tienda') }}
            </x-responsive-nav-link>

            <!-- Administración -->
            @if(auth()->check() && auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                {{ __('Productos') }}
            </x-responsive-nav-link>
            @endif

            <!-- Lista de deseos (usuarios o invitados, NO admins) -->
            @if($showWishlist)
            <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index*')">
                ❤️ Lista de Deseos
                @if($wishlistCount > 0)
                <span class="ml-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ $wishlistCount }}
                </span>
                @endif
            </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>

