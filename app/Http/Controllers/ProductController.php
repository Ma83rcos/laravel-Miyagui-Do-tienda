<?php
namespace App\Http\Controllers;
use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ProductController extends Controller{
use LoadsMockData;
/**
* Display a listing of the resource.
*/
public function index(): View{
    $products = $this->getProducts();
// Enrich products with offer data and calculate final prices
$enrichedProducts = $this->enrichProductsWithOffers($products);
return view('products.index', ['products' => $enrichedProducts]);
}
/**
* Display only products that have an active offer
*/
public function onSale(): View{
$products = $this->getProducts();
$enrichedProducts = $this->enrichProductsWithOffers($products);
// Filter only products with offers
$productsOnSale = array_filter($enrichedProducts, function($product) {
return $product['offer'] !== null;
});
return view('products.index', ['products' => $productsOnSale]);
}
/**
* Show the form for creating a new resource.
*/
public function create(){
// En una aplicación real, aquí se mostraría un formulario para crear un nuevo producto.
// En este ejemplo, simplemente redirigimos a la lista de productos.
return redirect()->route('products.index')
->with('success', 'Formulario de creación de producto (simulado)');
}
/**
* Store a newly created resource in storage.
*/
public function store(Request $request){
// En una aplicación real, aquí se guardaría en la base de datos
// Por ahora, solo redirigimos a la lista de productos
return redirect()->route('products.index')
->with('success', 'Producto creado exitosamente');
}
/**
* Display the specified resource.
*/
public function show(string $id): View{
// Validate ID format
if (!is_numeric($id) || $id < 1) {
    abort(404, 'ID de producto inválido');
}
$products = $this->getProducts();
// Find product by ID
$product = $products[$id] ?? null;
if (!$product) {
abort(404, 'Producto no encontrado');
}
// Enrich product with offer data
$enrichedProducts = $this->enrichProductsWithOffers([$id => $product]);
$product = $enrichedProducts[$id];
// Get product category
$categories = $this->getCategories();
$category = $categories[$product['category_id']] ?? null;
return view('products.show', compact('product', 'category'));
}
/**
* Show the form for editing the specified resource.
*/
public function edit(string $id){
// En una aplicación real, aquí se obtendrían los datos del productocorrespondiente al id recibido,
// así como las listas necesarias (por ejemplo, categorías, ofertas, etc.)para mostrarlas en un formulario de edición.
// En este ejemplo, simplemente redirigimos al detalle del producto.
return redirect()->route('products.show', $id)
->with('success', 'Producto editado');
}
/**
* Update the specified resource in storage.
*/
public function update(Request $request, string $id){
// En una aplicación real, aquí se actualizaría en la base de datos
// Por ahora, solo redirigimos al detalle del producto
return redirect()->route('products.show', $id)
->with('success', 'Producto actualizado exitosamente');
}
/**
* Remove the specified resource from storage.
*/
public function destroy(string $id){
// En una aplicación real, aquí se eliminaría de la base de datos
// Por ahora, solo redirigimos a la lista de productos
return redirect()->route('products.index')
->with('success', 'Producto eliminado exitosamente');
}
}
