<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Colores y tallas disponibles en la tienda
    private $colors = ['Blanco', 'Amarillo', 'Naranja','Verde' , 'Azul', 'Rojo','Marron','Negro', 'Unico'];
    private $sizes = ['S' , 'M' , 'L' , 'XL', '100x100' ];
    /**
     * Mostrar todos los productos (vista pública)
     */
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'offer']) // Carga la relación de categoría y oferta
            ->when($request->filled('search'), function ($query) use ($request) {
                // Si hay un término de búsqueda, filtrar por nombre o descripción
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            })
            ->get();

        // Retorna la vista de productos públicos con los datos
        return view('products.index', ['products' => $products]);
    }

    /**
     * Mostrar solo productos con oferta activa
     */
    public function onSale(): View
    {
        $products = Product::with(['category', 'offer'])
            ->whereNotNull('offer_id') // Filtra productos que tengan una oferta asignada
            ->get();

        return view('products.index', ['products' => $products]);
    }

    // ===========================
    // PANEL ADMIN - CREAR PRODUCTO
    // ===========================

    /**
     * Mostrar el formulario para crear un nuevo producto
     */
    public function create(): View
    {
        // Obtener todas las categorías y ofertas para los select del formulario
        $categories = Category::all();
        $offers = Offer::all();
        // Nuevo producto no tiene variantes
        $product = null;

        return view('admin.products.create', [
                     'product' => $product,
                     'categories' => $categories,
                     'offers' => $offers,
                     'variants' => [],
                     'colors' => $this->colors,
                     'sizes' => $this->sizes,   
                    ]);
    }

    /**
     * Guardar un nuevo producto en la base de datos
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
        ], [
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.unique' => 'Ya existe un producto con ese nombre.',
            'description.required' => 'La descripción es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image.max' => 'La imagen no debe superar los 2MB.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'offer_id.exists' => 'La oferta seleccionada no es válida.',
        ]);

        // Si se sube una imagen, guardarla en la carpeta 'products' del disco público
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Crear el producto en la base de datos
        $product = Product::create($validated);

        // Guardar las variantes
        if ($request->has('variants')) {
         foreach ($request->variants as $color => $sizes) {
          foreach ($sizes as $size => $stock) {
             $product->variants()->create([
                'color' => $color,
                'size' => $size,
                'stock' => (int) $stock,
             ]);
           }
         }
        }

        // Actualizar stock total del producto automáticamente
        $totalStock = $product->variants()->sum('stock');
        $product->update(['stock' => $totalStock]);


        // Redirigir al listado de productos admin con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Listado de productos en el panel de administración
     */
    public function adminIndex(Request $request): View
    {
    $query = Product::with(['category', 'offer'])->latest();

    // Filtrar por nombre si hay búsqueda
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }

    // Paginación con query string para mantener la búsqueda
    $products = $query->paginate(6)->appends($request->all());

    return view('admin.products.index', compact('products'));
    }

    // ===========================
    // DETALLE DE PRODUCTO PÚBLICO
    // ===========================

    /**
     * Mostrar un producto específico
     */
    public function show(string $id): View
    {
        // Validar que el ID sea un número positivo
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de producto inválido');
        }

        // Buscar el producto con categoría y oferta
        $product = Product::with(['category', 'offer', 'variants'])->findOrFail($id);

        $category = $product->category; // Obtener la categoría del producto

        // Agrupar variantes por color
        $variantsForBlade = $product->variants->groupBy('color')->map(function($group, $color) {
        return [
            'color' => $color,
            'sizes' => $group->pluck('stock', 'size')->toArray(), // enviamos todas, incluso 0
        ];
        })->values()->toArray();

        return view('products.show', compact('product', 'category', 'variantsForBlade'));
    }

    // ===========================
    // PANEL ADMIN - EDITAR PRODUCTO
    // ===========================

    /**
     * Formulario para editar un producto existente
     */
    public function edit(Product $product): View
    {
        // Obtener categorías y ofertas para los select del formulario
        $categories = Category::all();
        $offers = Offer::all();

        // Variantes agrupadas por color -> talla => stock
        //Transformar las avribales a Alpine.js
       $variantsForBlade = $product->variants->groupBy('color')->map(function($group, $color) {
        return [
        'color' => $color,
        'sizes' => $group->pluck('stock', 'size')->toArray(),
        ];
        })->values()->toArray();



       return view('admin.products.edit', [
                   'product' => $product,
                   'categories' => $categories,
                   'offers' => $offers,
                   'variantsForBlade' => $variantsForBlade,
                   'colors' => $this->colors,
                   'sizes' => $this->sizes,
                   ]);
    }

    /**
     * Actualizar un producto en la base de datos
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        // Validar datos
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
            'variants.*.*' => 'nullable|integer|min:0'
        ]);

        // Si se sube una nueva imagen, eliminar la anterior y guardar la nueva
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Actualizar producto
        $product->update($validated);

        // Actualizar o crear variantes
        if ($request->has('variants')) {
         foreach ($request->variants as $color => $sizes) {
          foreach ($sizes as $size => $stock) {
            $product->variants()->updateOrCreate(
                ['color' => $color, 'size' => $size],
                ['stock' => (int) $stock]
            );
          }
         }
        }

        // Recalcular stock total después de actualizar variantes
        $totalStock = $product->variants()->sum('stock');
        $product->update(['stock' => $totalStock]);


        // Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    // ===========================
    // PANEL ADMIN - ELIMINAR PRODUCTO
    // ===========================

    /**
     * Eliminar un producto
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Si el producto tiene imagen, eliminarla del disco
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Eliminar producto de la base de datos
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
