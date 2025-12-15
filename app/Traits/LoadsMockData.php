<?php
namespace App\Traits;
trait LoadsMockData
{
/**
* Load categories from mock file
*/
protected function getCategories(): array
{
return require database_path('data/mock-categories.php');
}
/**
* Load offers from mock file
*/
protected function getOffers(): array
{
return require database_path('data/mock-offers.php');
}
/**
* Load cart from mock file
*/
protected function getCart(): array
{
return require database_path('data/mock-cart.php');
}
/**
* Load products from mock file
*/
protected function getProducts(): array
{
return require database_path('data/mock-products.php');
}
/**
* Load all mock data at once
*/
protected function getAllMockData(): array
{
return [
'categories' => $this->getCategories(),
'offers' => $this->getOffers(),
'cart' => $this->getCart(),
'products' => $this->getProducts(),
];
}
/**
* Enrich products with their offer data and calculate final price
* This method adds 'offer' and 'final_price' to each product that has an offer
*/
protected function enrichProductsWithOffers(array $products): array
{
$offers = $this->getOffers();
return array_map(function($product) use ($offers) {
// Add offer data if product has an offer
if ($product['offer_id'] !== null &&
isset($offers[$product['offer_id']])) {
$offer = $offers[$product['offer_id']];
$product['offer'] = $offer;
// Calculate final price with discount
$discount = $product['price'] * ($offer['discount_percentage'] /
100);
$product['final_price'] = $product['price'] - $discount;
} else {
$product['offer'] = null;
$product['final_price'] = $product['price'];
}
return $product;
}, $products);
}
}