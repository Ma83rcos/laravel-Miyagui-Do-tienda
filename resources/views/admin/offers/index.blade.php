@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-2 md:space-y-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Ofertas
        </h2>

        {{-- Botón Crear Oferta --}}
        <a href="{{ route('admin.offers.create') }}" 
           class="inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase hover:bg-gray-100 transition mt-2 md:mt-0">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Nueva Oferta
        </a>
    </div>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descuento (%)</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($offers as $offer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $offer->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $offer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $offer->discount_percentage }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.offers.edit', $offer) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                                        <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Deseas eliminar esta oferta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No hay ofertas para mostrar
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    @if(method_exists($offers, 'links'))
                        <div class="mt-4">
                            {{ $offers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
