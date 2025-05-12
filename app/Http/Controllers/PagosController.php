<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function index()
    {
        return response()->json(Pagos::all(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_reserva' => 'required|integer',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
        ]);

        $pago = Pagos::create($data);
        return response()->json($pago, 201);
    }

    public function show($id)
    {
        $pago = Pagos::findOrFail($id);
        return response()->json($pago, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_reserva' => 'required|integer',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date',
        ]);

        $pago = Pagos::findOrFail($id);
        $pago->update($data);

        return response()->json($pago, 200);
    }

    public function destroy($id)
    {
        $pago = Pagos::findOrFail($id);
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado correctamente'], 200);
    }
}
