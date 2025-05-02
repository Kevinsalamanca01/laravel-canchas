<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;

class CanchaController extends Controller
{
    public function index()
    {
        return Cancha::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
        ]);

        return Cancha::create($request->all());
    }

    public function show($id)
    {
        return Cancha::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cancha = Cancha::findOrFail($id);
        $cancha->update($request->all());

        return $cancha;
    }

    public function destroy($id)
    {
        Cancha::destroy($id);

        return response()->json(['mensaje' => 'Cancha eliminada.']);
    }
}
