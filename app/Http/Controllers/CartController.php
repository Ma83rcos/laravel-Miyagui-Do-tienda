<?php
namespace App\Http\Controllers;
use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;
class CartController extends Controller{
use LoadsMockData;
/**
* Show cart overview
*/
public function index(): View{
$cart = $this->getCart();
$products = $this->getProducts();
// Add product names to cart data
$cartWithProducts = [];
foreach ($cart as $item) {
$product = $products[$item['product_id']] ?? null;
$cartWithProducts[] = array_merge($item, [
'name' => $product ? $product['name'] : 'Producto no encontrado',
'price' => $product ? $product['price'] : 0
]);
}
return view('cart.index', [
'cartItems' => $cartWithProducts
]);
}
/**
* Store a newly created cart item
*/
public function store(Request $request){
// En una aplicación real, aquí se guardaría el producto en el carrito
// Por ahora, solo redirigimos al carrito con un mensaje
return redirect()->route('cart.index')
->with('success', 'Producto añadido al carrito exitosamente');
}
/**
* Update the specified cart item
*/
public function update(Request $request, string $id)
{
// En una aplicación real, aquí se actualizaría la cantidad del producto en el carrito
// Por ahora, solo redirigimos al carrito con un mensaje
return redirect()->route('cart.index')
->with('success', 'Cantidad actualizada exitosamente');
}
}