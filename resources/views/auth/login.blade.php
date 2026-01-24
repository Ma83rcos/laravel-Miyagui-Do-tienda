<x-guest-layout>
    @section('title', 'Login Miyagui-Do')

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 space-y-6 mx-auto mt-20">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Iniciar Sesión</h2>

        <!-- Mensaje de sesión -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Recordarme -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-600">Recuérdame</label>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row sm:justify-between gap-3 mt-4">
                <x-primary-button class="w-full sm:w-auto px-4 py-2">
                    Iniciar Sesión
                </x-primary-button>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-800 self-center sm:self-start" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <a href="{{ route('welcome') }}" class="w-full sm:w-auto text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                    Volver a la Tienda
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
