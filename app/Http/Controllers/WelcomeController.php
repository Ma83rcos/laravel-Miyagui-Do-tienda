<?php
namespace App\Http\Controllers;
use App\Traits\LoadsMockData;
use Illuminate\Http\Request;
use Illuminate\View\View;
class WelcomeController extends Controller
{
use LoadsMockData;
/**
* Show the welcome page with featured content
*/
public function index(): View
{
$products = $this->getProducts();
$categories = $this->getCategories();
// Enrich products with offer data before slicing
$enrichedProducts = $this->enrichProductsWithOffers($products);
// Get featured products (first 3 products for the featured section)
$featuredProducts = array_slice($enrichedProducts, 0, 3, true);
// Get featured categories (first 4 categories for the categories section)
$featuredCategories = array_slice($categories, 0, 4, true);
return view('welcome', compact('featuredProducts', 'featuredCategories'));
}
}