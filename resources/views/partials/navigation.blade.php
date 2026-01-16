<nav class="hidden md:flex space-x-8">
    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('welcome') ? 'text-primary-600 font-semibold' : '' }}">
        Inicio
    </a>
    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('products.*') ? 'text-primary-600 font-semibold' : '' }}">
        Productos
    </a>
    <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('categories.*') ? 'text-primary-600 font-semibold' : '' }}">
        Categorías
    </a>
    <a href="{{ route('offers.index') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('offers.*') ? 'text-primary-600 font-semibold' : '' }}">
        Ofertas
    </a>
     <a href="{{ route('contact.index') }}" 
       class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('contact.index') ? 'text-primary-600 font-semibold' : '' }}">
        Contacto
    </a>
    
    {{-- INVITADO --}}
    @guest
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('login') ? 'text-primary-600 font-semibold' : '' }}">
            Login
        </a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('register') ? 'text-primary-600 font-semibold' : '' }}">
                Registrar
            </a>
        @endif    
    @endguest

    {{-- USUARIO AUTENTICADO --}}
    @auth
        @if(Auth::user()->isAdmin())
            {{-- ADMIN → Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('admin.*') ? 'text-primary-600 font-semibold' : '' }}">
                Administrar tienda
            </a>
        @else
              {{-- USUARIO NORMAL → Icono + Nombre con dropdown --}}
        <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 transition focus:outline-none">
                {{-- Icono de usuario --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="font-medium">{{ Auth::user()->name }}</span>
            </button>

            {{-- Dropdown oculto, aparece al hover --}}
            <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-150 z-50">
                {{-- Perfil --}}
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Perfil
                </a>
                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
        @endif
    @endauth
</nav>