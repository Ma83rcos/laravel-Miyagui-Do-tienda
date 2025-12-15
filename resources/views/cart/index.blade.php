@extends('layouts.app')
@section('title', 'Carrito - Mi Tienda')
@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Mi Carrito</h1>
        <p class="text-gray-600">Verifica los productos en tu carrito.
        </p>
    </div>
    @if(!empty($cartItems))
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium
                             text-gray-500 uppercase tracking-wider">
                            Producto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium 
                             text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium
                             text-gray-500 uppercase tracking-wider">
                            Cantidad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium
                             text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-
900">{{ $item['name'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-smtext-gray-900">
                            €{{ $item['price'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm
text-gray-900">
                            {{ $item['quantity'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm
font-medium text-gray-900">
                            €{{ $item['price'] * $item['quantity'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No hay productos en tu carrito.</p>
        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-primary-600 text-white px-6 py-3
rounded-lg hover:bg-primary-700 transition">
            Ver Productos
        </a>
    </div>
    @endif
</div>
@endsection
