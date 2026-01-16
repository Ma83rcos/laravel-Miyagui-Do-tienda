<?php
namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfferController extends Controller
{
    // ============================
    // TIENDA - Oferta pública
    // ============================

    /**
     * Mostrar todas las ofertas en la tienda
     */
    public function index(): View
    {
        $offers = Offer::all();
        return view('offers.index', ['offers' => $offers]);
    }

    /**
     * Mostrar los productos de una oferta específica
     */
    public function show(string $id): View
    {
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de oferta inválido');
        }

        $offer = Offer::find($id);
        if (!$offer) {
            abort(404, 'Oferta no encontrada');
        }

        $offerProducts = $offer->products()->with(['category'])->get();

        return view('offers.show', compact('offer', 'offerProducts'));
    }

    // ============================
    // ADMIN - Gestión de ofertas
    // ============================

    /**
     * Listado de ofertas para admin
     */
    public function adminIndex(): View
    {
        $offers = Offer::latest()->paginate(15); // Paginado
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Formulario para crear nueva oferta
     */
    public function create(): View
    {
        return view('admin.offers.create');
    }

    /**
     * Guardar nueva oferta en la base de datos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:offers,name',
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Offer::create($validated);

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta creada exitosamente.');
    }

    /**
     * Formulario para editar oferta existente
     */
    public function edit(Offer $offer): View
    {
        return view('admin.offers.edit', compact('offer'));
    }

    /**
     * Actualizar oferta en la base de datos
     */
    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:offers,name,' . $offer->id,
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $offer->update($validated);

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta actualizada exitosamente.');
    }

    /**
     * Eliminar oferta
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
                         ->with('success', 'Oferta eliminada exitosamente.');
    }
}
