{{-- 
    Envolvemos TODA la card dentro de un <a>
    para que sea completamente clickeable 
--}}
<a href="{{ route('categories.show', $category->id) }}"
   class="block bg-white rounded-lg shadow-md p-6 product-card cursor-pointer transition duration-300 hover:shadow-xl hover:-translate-y-1 hover:bg-gray-50 {{ $class }}">

     {{-- Icono de la categoría --}}
    <div class="text-4xl text-primary-500 mb-4 transition duration-300 group-hover:scale-110">
        📦
    </div>

    {{-- Nombre de la categoría --}}
    <h4 class="text-xl font-semibold mb-2 text-gray-900">
        {{ $category->name }}
    </h4>

    {{-- Descripción --}}
    <p class="text-gray-600 text-sm leading-relaxed">
        {{ $category->description }}
    </p>

</a>