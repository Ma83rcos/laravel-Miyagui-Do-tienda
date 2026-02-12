@csrf {{-- Token CSRF de Laravel para proteger el formulario --}}

{{-- Nombre del Producto --}}
<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
    <input type="text" id="name" name="name" 
           value="{{ old('name', $product->name ?? '') }}" 
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" 
           required>
    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción del Producto --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Descripción *</label>
    <textarea id="description" name="description" rows="4" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" 
              required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Imagen del Producto --}}
<div>
    <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
    <input type="file" id="image" name="image" 
           accept="image/jpeg,image/png,image/jpg,image/webp" 
           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
    <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB</p>
    @error('image')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Precio del Producto --}}
<div>
    <label for="price" class="block text-sm font-medium text-gray-700">Precio (€) *</label>
    <input type="number" id="price" name="price" 
           value="{{ old('price', $product->price ?? '') }}" 
           step="0.01" min="0" 
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('price') border-red-500 @enderror" 
           required>
    @error('price')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Categoría del Producto --}}
<div>
    <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
    <select id="category_id" name="category_id" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror" 
            required>
        <option value="">Selecciona una categoría</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Oferta (Opcional) --}}
<div>
    <label for="offer_id" class="block text-sm font-medium text-gray-700">Oferta (Opcional)</label>
    <select id="offer_id" name="offer_id" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('offer_id') border-red-500 @enderror">
        <option value="">Sin oferta</option>
        @foreach($offers as $offer)
            <option value="{{ $offer->id }}" {{ old('offer_id', $product->offer_id ?? '') == $offer->id ? 'selected' : '' }}>
                {{ $offer->name }} (-{{ $offer->discount_percentage }}%)
            </option>
        @endforeach
    </select>
    @error('offer_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Variantes (Color + Talla) --}}
<div x-data="variantsForm()" class="mt-6">

    {{-- Stock Total calculado automáticamente --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Stock Total</label>
        <input type="number"
               :value="totalStock"
               readonly
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 text-gray-800 font-semibold focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <p class="mt-1 text-xs text-gray-500">
            El stock total se calcula automáticamente sumando todas las variantes.
        </p>
    </div>

    <h3 class="text-lg font-medium text-gray-900 mb-2">Variantes (Color + Talla)</h3>

    {{-- Lista de variantes dinámicas --}}
    <template x-for="(variant, index) in variants" :key="index">
        <div class="border p-4 rounded-md mb-4 bg-gray-50">
            
            {{-- Selección de color --}}
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <label class="font-medium text-gray-700">Color:</label>
                    <select x-model="variant.color" class="rounded border-gray-300 shadow-sm">
                        <option value="">Selecciona un color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" @click="removeVariant(index)" class="px-2 py-1 text-sm text-red-600 hover:text-red-900">Eliminar</button>
            </div>

            {{-- Tallas y stock por color --}}
            <div class="grid grid-cols-4 gap-2">
                @foreach($sizes as $size)
                    <div class="flex flex-col">
                        <label class="text-sm text-gray-700">{{ $size }}</label>
                        <input type="number"
                               :name="`variants[${variant.color}][{{ $size }}]`"
                               x-model.number="variant.sizes['{{ $size }}']"
                               min="0"
                               class="mt-1 rounded border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                @endforeach
            </div>
        </div>
    </template>
   
   <div class="flex gap-4 mt-4">
    {{-- Botón para añadir variante --}}
    <button type="button" @click="addVariant()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Añadir Talla-Color
    </button>

    {{-- Botón de enviar formulario --}}
    
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            {{ $buttonText }}
        </button>
    </div>
   </div> 
</div>

{{-- Script Alpine.js para manejo de variantes --}}
<script>
function variantsForm() {
    return {
        variants: @json($variantsForBlade ?? []),

        get totalStock() {
            return this.variants.reduce((total, variant) => {
                return total + Object.values(variant.sizes).reduce((a, b) => a + (parseInt(b) || 0), 0);
            }, 0);
        },

        addVariant() {
            this.variants.push({
                color: '',
                sizes: {
                    @foreach($sizes as $size)
                        '{{ $size }}': 0,
                    @endforeach
                }
            });
        },

        removeVariant(index) {
            this.variants.splice(index, 1);
        }
    }
}
</script>
