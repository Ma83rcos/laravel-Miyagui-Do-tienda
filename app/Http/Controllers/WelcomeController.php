<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        // Productos destacados (por ejemplo los 3 más recientes con oferta)
        $featuredProducts = Product::with(['category', 'offer'])
            ->whereNotNull('offer_id')
            ->take(3)
            ->get();

        // Todas las categorías
        $featuredCategories = Category::all();

        return view('welcome', compact('featuredProducts', 'featuredCategories'));
    }
}
