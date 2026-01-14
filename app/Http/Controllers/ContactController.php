<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller{

    //Mostrar la página de contacto
    public function index()
    {
        return view('contact'); // Aquí carga tu contact.blade.php
    }
     // Enviar mensaje del formulario
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Por ahora solo redirige con mensaje de éxito
        return redirect()->route('contact.index')->with('success', '¡Mensaje enviado correctamente!');
    }
}
