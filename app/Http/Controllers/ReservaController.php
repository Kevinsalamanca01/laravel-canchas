<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        return Reserva::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_cancha' => 'required|integer',
            'fecha_reserva' => 'required|date',
            'hora_reserva' => 'required',
        ]);

        return Reserva::create($request->all());
    }

    public function show($id)
    {
        return Reserva::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->all());

        return $reserva;
    }

    public function destroy($id)
    {
        Reserva::destroy($id);

        return response()->json(['mensaje' => 'Reserva eliminada.']);
    }
}
