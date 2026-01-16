@extends('layouts.admin')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Editar Categoría
    </h2>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('admin.categories.update', $category) }}"
                      method="POST"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nombre de la categoría --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nombre *
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                   focus:border-indigo-300 focus:ring focus:ring-indigo-200
                                   focus:ring-opacity-50
                                   @error('name') border-red-500 @enderror"
                        >

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
