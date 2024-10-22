<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function contacto()
    {
        return view('ayuda.contacto');
    }
}
