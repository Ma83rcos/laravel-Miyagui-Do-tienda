<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // ============================
    // TIENDA - Categorías públicas
    // ============================

    /**
     * Mostrar todas las categorías
     */
    public function index(): View
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Mostrar los productos de una categoría específica
     */
    public function show(string $id): View
    {
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de categoría inválido');
        }

        $category = Category::find($id);
        if (!$category) {
            abort(404, 'Categoría no encontrada');
        }

        $categoryProducts = $category->products()->with(['offer'])->get();

        return view('categories.show', compact('category', 'categoryProducts'));
    }

    // ============================
    // ADMIN - Gestión de categorías
    // ============================

    /**
     * Listado de categorías para admin
     */
    public function adminIndex(): View
    {
        $categories = Category::latest()->paginate(15); // Paginado
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulario para crear nueva categoría
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Guardar nueva categoría
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048', // imagen opcional, max 2MB
        ]);
        // Guardar imagen si se sube
        if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Formulario para editar categoría existente
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048', // imagen opcional, max 2MB
        ]);
        if ($request->hasFile('image')) {
        // Eliminar imagen anterior si existe
        if ($category->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
        }
        $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar categoría
     */
    public function destroy(Category $category)
    {
        // Opcional: verificar si tiene productos antes de eliminar
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                             ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoría eliminada exitosamente.');
    }
}
