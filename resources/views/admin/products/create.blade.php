@extends('layouts.admin')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
        Crear Nuevo Producto
    </h2>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @include('admin.products._form', ['buttonText' => 'Crear Producto'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
