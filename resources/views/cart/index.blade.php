@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">🛒 Carrito de Compras</h1>

    @if($cartProducts->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Tu carrito está vacío</h2>
            <p class="text-gray-600 mb-6">¡Añade productos para comenzar tu compra!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                Ver Productos
            </a>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @php $total = 0; @endphp
            @foreach($cartProducts as $product)
                @php
                    $subtotal = $product->final_price * $product->quantity;
                    $total += $subtotal;
                @endphp

                <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col sm:flex-row items-center gap-4">
                    <!-- Imagen -->
                    <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-md flex items-center justify-center border">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-full w-full rounded-md">
                        @else
                            <span class="text-3xl">📦</span>
                        @endif
                    </div>

                    <!-- Info producto -->
                    <div class="flex-1 flex flex-col w-full">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-900">{{ $product->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                @if($product->offer)
                                    <span class="inline-block bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full mt-1">
                                        🏷️ -{{ $product->offer->discount_percentage }}%
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($product->offer)
                                    <div class="line-through text-gray-400 text-sm">€{{ number_format($product->price,2) }}</div>
                                    <div class="font-bold text-red-600">€{{ number_format($product->final_price,2) }}</div>
                                @else
                                    <div class="font-bold text-gray-900">€{{ number_format($product->final_price,2) }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Variantes -->
                        <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-700">
                            @if($product->color)<div><strong>Color:</strong> {{ $product->color }}</div>@endif
                            @if($product->size)<div><strong>Talla:</strong> {{ $product->size }}</div>@endif
                        </div>

                        <!-- Cantidad y eliminar -->
                        <div class="flex flex-wrap gap-4 mt-4 items-center">
                            <form action="{{ route('cart.update', $product->cart_key) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" class="w-16 h-10 border rounded-md text-center">
                                <button type="submit" class="px-3 py-1 bg-primary text-white rounded-md hover:bg-primary-700 transition">Actualizar</button>
                            </form>

                            <form action="{{ route('cart.destroy', $product->cart_key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 transition">Eliminar</button>
                            </form>

                            <div class="ml-auto font-semibold text-gray-900">Subtotal: €{{ number_format($subtotal,2) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Total y acciones -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                <div class="text-xl font-bold text-gray-800">Total: €{{ number_format($total,2) }}</div>
                <div class="flex gap-4">
                    <a href="{{ route('products.index') }}" class=" bg-gray-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-gray-700 transition flex items-center justify-center text-sm">
                        Seguir Comprando
                    </a>
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-green-700 transition">
                            Realizar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
