<?php
namespace App\Http\Controllers;
use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;
class CategoryController extends Controller
{
use LoadsMockData;
/**
* Show all categories
*/
public function index(): View{
$categories = $this->getCategories();
return view('categories.index', ['categories' => $categories]);
}
/**
* Show products from a specific category
*/
public function show(string $id): View{
// Validate ID format
if (!is_numeric($id) || $id < 1) {
abort(404, 'ID de categoría inválido');
}
$categories = $this->getCategories();
// Find category by ID
$category = $categories[$id] ?? null;
if (!$category) {
abort(404, 'Categoría no encontrada');
}
// Load and enrich products
$products = $this->getProducts();
// Filter products by category
$categoryProducts = array_filter($products, function($product) use ($id) {
return $product['category_id'] == $id;
});
$categoryProducts = $this->enrichProductsWithOffers($categoryProducts);
return view('categories.show', compact('category', 'categoryProducts'));
}
}