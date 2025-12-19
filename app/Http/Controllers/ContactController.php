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
}
