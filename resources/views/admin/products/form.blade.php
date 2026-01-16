@csrf

{{-- Nombre del Producto --}}
<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
    <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" required>
    @error('name')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Descripción *</label>
    <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Imagen del Producto --}}
<div>
    <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
    <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB</p>
    @error('image')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Precio --}}
<div>
    <label for="price" class="block text-sm font-medium text-gray-700">Precio (€) *</label>
    <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('price') border-red-500 @enderror" required>
    @error('price')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Stock --}}
<div>
    <label for="stock" class="block text-sm font-medium text-gray-700">Stock inicial *</label>
    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('stock') border-red-500 @enderror" required>
    <p class="mt-1 text-xs text-gray-500">Cantidad disponible en almacén</p>
    @error('stock')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Categoría --}}
<div>
    <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
    <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror" required>
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
    <select id="offer_id" name="offer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('offer_id') border-red-500 @enderror">
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

{{-- Botones de Acción --}}
<div class="flex justify-end space-x-4 pt-4">
    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">Cancelar</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
        {{ $buttonText ?? 'Guardar Producto' }}
    </button>
</div>
