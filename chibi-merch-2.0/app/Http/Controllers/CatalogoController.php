<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('id')->get();

        return view('catalogo.index', compact('productos'));
    }

    public function mostrar($id)
    {
        $producto = Producto::findOrFail($id);

        return view('catalogo.mostrar', compact('producto'));
    }
}