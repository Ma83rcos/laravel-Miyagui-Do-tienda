@extends('layouts.admin')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Crear Nueva Oferta
    </h2>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('admin.offers.store') }}"
                      method="POST"
                      class="space-y-6">
                    @csrf

                    {{-- Nombre de la oferta --}}
                    <div>
                        <label for="name"
                               class="block text-sm font-medium text-gray-700">
                            Nombre *
                        </label>

                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-300 focus:ring focus:ring-indigo-200
                                      focus:ring-opacity-50
                                      @error('name') border-red-500 @enderror">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Porcentaje de descuento --}}
                    <div>
                        <label for="discount_percentage"
                               class="block text-sm font-medium text-gray-700">
                            Descuento (%) *
                        </label>

                        <input type="number"
                               id="discount_percentage"
                               name="discount_percentage"
                               value="{{ old('discount_percentage') }}"
                               min="0"
                               max="100"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                      focus:border-indigo-300"
