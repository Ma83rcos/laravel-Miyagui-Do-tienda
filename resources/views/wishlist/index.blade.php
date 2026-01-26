<x-app-layout pageTitle="Lista Favoritos">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Lista de Favoritos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- ADMIN: no tiene favoritos --}}
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="text-center py-12">
                                <div class="text-3xl mb-4">⚠️</div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                    Los administradores no tienen lista de favoritos
                                </h3>
                                <p class="text-gray-600">
                                    La lista de favoritos solo está disponible para usuarios normales e invitados.
                                </p>
                            </div>
                        @endif
                    @endauth

                    {{-- USUARIOS NORMALES / INVITADOS --}}
                    @if(!auth()->check() || !auth()->user()->isAdmin())

                        @if($wishlistProducts->isEmpty())
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">💔</div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                    Tu lista de favoritos está vacía
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    Explora nuestros productos y guarda tus favoritos
                                </p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-block bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                                    Ver Productos
                                </a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($wishlistProducts as $product)
                                    <x-product-card :product="$product">

                                        {{-- Botón eliminar de favoritos --}}
                                        <x-slot name="topAction">
                                            <form action="{{ route('favorites.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-2xl hover:scale-125 transition-transform"
                                                        title="Eliminar de favoritos">
                                                    ❌
                                                </button>
                                            </form>
                                        </x-slot>

                                        {{-- Acciones --}}
                                        <x-slot name="actions">
                                            <div class="flex gap-2">
                                                <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit"
                                                            class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                                                        🛒 Añadir al Carrito
                                                    </button>
                                                </form>

                                                <a href="{{ route('products.show', $product->id) }}"
                                                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                                                    Ver
                                                </a>
                                            </div>
                                        </x-slot>

                                    </x-product-card>
                                @endforeach
                            </div>
                        @endif

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
