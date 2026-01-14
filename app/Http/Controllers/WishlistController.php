<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Muestra la lista de deseos (favoritos)
     * - Usuarios autenticados: de la BD
     * - Invitados: de la sesión
     */
    public function index(): View
    {
        if (Auth::check()) {
            $wishlistProducts = Auth::user()->wishlist()->with(['category', 'offer'])->get();
        } else {
            $wishlistIds = session()->get('wishlist', []);
            $wishlistProducts = Product::with(['category', 'offer'])->whereIn('id', $wishlistIds)->get();
        }

        return view('wishlist.index', compact('wishlistProducts'));
    }

    /**
     * Añade un producto a favoritos
     * - Usuarios: DB
     * - Invitados: sesión
     */
    public function store(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->wishlist()->where('product_id', $id)->exists()) {
                return redirect()->back()->with('info', 'Este producto ya está en tus favoritos.');
            }
            $user->wishlist()->attach($id);
        } else {
            $wishlist = session()->get('wishlist', []);
            if (!in_array($id, $wishlist)) {
                $wishlist[] = $id;
                session(['wishlist' => $wishlist]);
            }
        }

        return redirect()->back()->with('success', 'Producto añadido a favoritos.');
    }

    /**
     * Elimina un producto de favoritos
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        if (Auth::check()) {
            Auth::user()->wishlist()->detach($id);
        } else {
            $wishlist = session()->get('wishlist', []);
            if (($key = array_search($id, $wishlist)) !== false) {
                unset($wishlist[$key]);
                session(['wishlist' => $wishlist]);
            }
        }

        return redirect()->back()->with('success', 'Producto eliminado de favoritos.');
    }
}
