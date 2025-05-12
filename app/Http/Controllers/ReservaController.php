<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ReservaController extends Controller
{
    public function index()
    {
        return response()->json(Reserva::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            // Validación de los datos de la reserva
            $validated = $request->validate([
                'id_usuario' => 'required|integer|exists:usuarios,id_usuario',
                'id_cancha' => 'required|integer|exists:canchas,id_cancha',
                'fecha_reserva' => 'required|date',
                'hora_reserva' => 'required|date_format:H:i',
            ]);

            // Verificación de la disponibilidad de la cancha en la fecha y hora solicitada
            $existeReserva = Reserva::where('id_cancha', $validated['id_cancha'])
                ->where('fecha_reserva', $validated['fecha_reserva'])
                ->where('hora_reserva', $validated['hora_reserva'])
                ->exists();

            if ($existeReserva) {
                return response()->json([
                    'mensaje' => 'La cancha ya está reservada para esa fecha y hora.'
                ], 409); // 409 Conflicto
            }

            // Si no hay conflicto, crear la nueva reserva
            $reserva = Reserva::create($validated);
            return response()->json($reserva, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'mensaje' => 'Datos inválidos.',
                'errores' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'mensaje' => 'Error al guardar la reserva.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);
            return response()->json($reserva, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['mensaje' => 'Reserva no encontrada.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reserva = Reserva::findOrFail($id);

            // Validación de los datos de la reserva
            $validated = $request->validate([
                'id_usuario' => 'sometimes|required|integer|exists:usuarios,id_usuario',
                'id_cancha' => 'sometimes|required|integer|exists:canchas,id_cancha',
                'fecha_reserva' => 'sometimes|required|date',
                'hora_reserva' => 'sometimes|required|date_format:H:i',
            ]);

            // Verificación de la disponibilidad de la cancha en la nueva fecha y hora solicitada
            $existeReserva = Reserva::where('id_cancha', $validated['id_cancha'])
                ->where('fecha_reserva', $validated['fecha_reserva'])
                ->where('hora_reserva', $validated['hora_reserva'])
                ->where('id', '!=', $id) // Excluir la reserva actual
                ->exists();

            if ($existeReserva) {
                return response()->json([
                    'mensaje' => 'La cancha ya está reservada para esa fecha y hora.'
                ], 409); // 409 Conflicto
            }

            // Si no hay conflicto, actualizar la reserva
            $reserva->update($validated);
            return response()->json($reserva, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['mensaje' => 'Reserva no encontrada.'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'mensaje' => 'Datos inválidos.',
                'errores' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar la reserva.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);

            // Verificación de la disponibilidad de la cancha en la fecha y hora de la reserva
            $existeReserva = Reserva::where('id_cancha', $reserva->id_cancha)
                ->where('fecha_reserva', $reserva->fecha_reserva)
                ->where('hora_reserva', $reserva->hora_reserva)
                ->where('id', '!=', $id) // Excluir la reserva actual
                ->exists();

            if ($existeReserva) {
                return response()->json([
                    'mensaje' => 'La cancha ya está reservada para esa fecha y hora.'
                ], 409); // 409 Conflicto
            }

            // Si no hay conflicto, eliminar la reserva
            $reserva->delete();

            return response()->json(['mensaje' => 'Reserva eliminada.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['mensaje' => 'Reserva no encontrada.'], 404);
        } catch (QueryException $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar la reserva.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
