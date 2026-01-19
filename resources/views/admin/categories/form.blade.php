@csrf

{{-- Nombre de la Categoría --}}
<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Categoría *</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" 
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" 
           required>
    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
    <textarea id="description" name="description" rows="4" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Imagen de la Categoría --}}
<div>
    <label for="image" class="block text-sm font-medium text-gray-700">Imagen de la Categoría</label>
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" 
           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
    <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB</p>
    @error('image')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

    @if(isset($category) && $category->image)
        <div class="mt-2">
            <p>Imagen actual:</p>
            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="max-width: 200px;">
        </div>
    @endif
</div>

{{-- Botones --}}
<div class="flex justify-end space-x-4 pt-4">
    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">Cancelar</a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
        {{ $buttonText ?? 'Guardar Categoría' }}
    </button>
</div>
