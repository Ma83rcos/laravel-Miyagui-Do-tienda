<x-guest-layout>
    @section('title', 'Registro Miyagui-Do')

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 space-y-6 mx-auto mt-20">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Registro de Usuario</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row sm:justify-between gap-3 mt-4">
                <x-primary-button class="w-full sm:w-auto px-4 py-2">
                    Registrarse
                </x-primary-button>

                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 self-center sm:self-start">
                    ¿Ya tienes cuenta? Iniciar sesión
                </a>

                <a href="{{ route('welcome') }}" class="w-full sm:w-auto text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                    Volver a la Tienda
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
