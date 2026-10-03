<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('id')->get();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.form', ['producto' => new Producto()]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        $imagen = $request->file('imagen');
        if ($imagen) {
            $datos['imagen'] = $imagen->store('productos', 'public');
        } else {
            $datos['imagen'] = 'img/productos/sin-imagen.png';
        }

        Producto::create($datos);

        return redirect()->route('productos.index')
            ->with('exito', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);

        return view('productos.form', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $datos = $this->validar($request);

        $imagen = $request->file('imagen');
        if ($imagen) {
            $datos['imagen'] = $imagen->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()->route('productos.index')
            ->with('exito', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        Producto::findOrFail($id)->delete();

        return redirect()->route('productos.index')
            ->with('exito', 'Producto eliminado correctamente.');
    }

    private function validar(Request $request)
    {
        return $request->validate([
            'nombre' => 'required|string|max:120',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [], [
            'nombre' => 'nombre',
            'descripcion' => 'descripcion',
            'precio' => 'precio',
            'stock' => 'stock',
            'imagen' => 'imagen',
        ]);
    }
}