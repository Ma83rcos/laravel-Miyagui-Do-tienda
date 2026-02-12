<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito de compras con los datos de la sesión.
     */
    public function index(): View
    {
        // Obtenemos el carrito desde la sesión, o un array vacío si no existe
        $cart = session()->get('cart', []);

        // Recorremos cada elemento del carrito para cargar los productos
        $cartProducts = collect($cart)->map(function ($item, $key) {
            // Extraemos el ID del producto desde la clave de la sesión
            $productId = explode('-', $key)[0];

            // Cargamos el producto con su categoría y oferta
            $product = Product::with(['category', 'offer'])->find($productId);
            if (!$product) return null;

            // Asignamos la cantidad, color y talla desde la sesión
            $product->quantity = $item['quantity'];
            $product->color = $item['color'] ?? null;
            $product->size = $item['size'] ?? null;

            // Guardamos la clave del carrito para usar en update/destroy
            $product->cart_key = $key;

            return $product;
        })->filter(); // Eliminamos posibles valores nulos

        // Retornamos la vista con los productos del carrito
        return view('cart.index', [
            'cartProducts' => $cartProducts
        ]);
    }

    /**
     * Añade un producto al carrito de compras en la sesión.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $productId = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');

        // Obtenemos el carrito desde la sesión
        $cart = session()->get('cart', []);

        // Generamos una "clave única" para el producto + color + talla
        // Esto permite que variantes diferentes se guarden como productos distintos
        $cartKey = $productId;
        if ($color) $cartKey .= '-' . $color;
        if ($size) $cartKey .= '-' . $size;

        // Si ya existe el producto en el carrito, aumentamos la cantidad
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            // Si no existe, lo agregamos con cantidad 1 y variantes
            $cart[$cartKey] = [
                'quantity' => 1,
                'color' => $color,
                'size' => $size
            ];
        }

        // Guardamos el carrito actualizado en la sesión
        session()->put('cart', $cart);

        return redirect()->back()->with('success', '¡Producto añadido al carrito!');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cantidad actualizada correctamente.');
        }

        return redirect()->route('cart.index')->with('error', 'El producto no se encontró en el carrito.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function destroy(string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->route('cart.index')->with('error', 'El producto no se encontró en el carrito.');
    }

    /**
     * Simula la finalización de la compra.
     */
    public function checkout(): RedirectResponse
    {
        session()->forget('cart'); // Limpiamos el carrito
        return redirect()->route('welcome')->with('success', '¡Pedido realizado con éxito! Gracias por tu compra.');
    }
}
