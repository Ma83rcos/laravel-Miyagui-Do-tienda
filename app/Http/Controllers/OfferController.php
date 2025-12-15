<?php
namespace App\Http\Controllers;
use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;
class OfferController extends Controller{
use LoadsMockData;
/**
* Show all offers
*/
public function index(): View{
$offers = $this->getOffers();
return view('offers.index', ['offers' => $offers]);
}
/**
* Show products with a specific offer
*/
public function show(string $id): View{
// Validate ID format
if (!is_numeric($id) || $id < 1) {
abort(404, 'ID de oferta inválido');
}
$offers = $this->getOffers();
// Find offer by ID
$offer = $offers[$id] ?? null;
if (!$offer) {
abort(404, 'Oferta no encontrada');
}
// Load and enrich products
$products = $this->getProducts();
// Filter products by offer (un producto solo puede tener una oferta)
$offerProducts = array_filter($products, function($product) use ($id) {
return $product['offer_id'] == $id;
});
$offerProducts = $this->enrichProductsWithOffers($offerProducts);
return view('offers.show', compact('offer', 'offerProducts'));
}
}