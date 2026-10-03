<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);
        $total = 0;
        $detalle = [];

        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if (!$producto) {
                continue;
            }
            $subtotal = $producto->precio * $cantidad;
            $total += $subtotal;
            $detalle[] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
            ];
        }

        $unidades = 0;
        foreach ($carrito as $cantidad) {
            $unidades += $cantidad;
        }

        return view('carrito.index', compact('detalle', 'total', 'unidades'));
    }

    public function agregar(Request $request)
    {
        $datos = $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'nullable|integer|min:1|max:99',
        ]);

        $producto = Producto::findOrFail($datos['producto_id']);
        $pedidas = $datos['cantidad'] ?? 1;

        if ($producto->stock < $pedidas) {
            return back()->with('error', 'No hay suficientes unidades de ' . $producto->nombre . '.');
        }

        $carrito = session('carrito', []);
        $yaEnCarrito = $carrito[$producto->id] ?? 0;
        $nuevoTotal = $yaEnCarrito + $pedidas;

        if ($producto->stock < $nuevoTotal) {
            return back()->with('error', 'Solo quedan ' . $producto->stock . ' unidades de ' . $producto->nombre . '.');
        }

        $carrito[$producto->id] = $nuevoTotal;
        session(['carrito' => $carrito]);

        return back()->with('exito', $producto->nombre . ' se agrego al carrito.');
    }

    public function actualizar(Request $request)
    {
        $datos = $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:0|max:99',
        ]);

        $carrito = session('carrito', []);
        $id = $datos['producto_id'];
        $cantidad = $datos['cantidad'];

        if ($cantidad == 0) {
            unset($carrito[$id]);
        } else {
            $producto = Producto::find($id);
            if ($producto && $producto->stock < $cantidad) {
                return back()->with('error', 'Solo hay ' . $producto->stock . ' unidades disponibles.');
            }
            $carrito[$id] = $cantidad;
        }

        session(['carrito' => $carrito]);

        return back()->with('exito', 'Carrito actualizado.');
    }

    public function vaciar()
    {
        session()->forget('carrito');

        return back()->with('exito', 'Carrito vaciado.');
    }
}