@extends('layouts.public')
@section('title', 'Contacto Miyagui-Do')
@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Contacta con Nosotros</h1>
            <p class="text-gray-600">Estamos disponibles para tus consultas. ¡Escríbenos y te responderemos pronto!</p>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mensaje -->
                <div>
                    <label for="message" class="block text-gray-700 font-medium mb-1">Mensaje</label>
                    <textarea id="message" name="message" rows="5"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-600 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit"
                            class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold">
                        Enviar Mensaje
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
