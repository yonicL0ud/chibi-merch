<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto.index');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:120',
            'correo' => 'required|email|max:150',
            'asunto' => 'required|string|max:120',
            'mensaje' => 'required|string|max:2000',
        ]);

        Mensaje::create($datos);

        return redirect()->route('contacto.index')
            ->with('exito', 'Gracias por escribirnos. Te responderemos pronto.');
    }
}