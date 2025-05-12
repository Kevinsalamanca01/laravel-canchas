<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidad;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    public function index()
    {
        // Obtiene todas las disponibilidades y las asocia con las canchas
        return response()->json(Disponibilidad::with('cancha')->get(), 200);
    }

    public function show($id)
    {
        try {
            // Busca una disponibilidad por su id, si no existe lanza una excepción
            $disponibilidad = Disponibilidad::with('cancha')->findOrFail($id);
            return response()->json($disponibilidad, 200);
        } catch (\Exception $e) {
            // En caso de error (no encontrada), devuelve un mensaje de error
            return response()->json(['error' => 'Disponibilidad no encontrada'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Valida los datos de la solicitud
            $data = $request->validate([
                'id_cancha' => 'required|integer|exists:canchas,id_cancha',
                'fecha' => 'required|date',
                'hora' => 'required|string',
                'estado' => 'required|string',
            ]);

            // Crea una nueva disponibilidad con los datos validados
            $disponibilidad = Disponibilidad::create($data);
            return response()->json($disponibilidad, 201);
        } catch (\Exception $e) {
            // Si ocurre un error al crear la disponibilidad, devuelve un error
            return response()->json(['error' => 'Error al crear disponibilidad'], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            // Valida los datos de la solicitud
            $data = $request->validate([
                'id_cancha' => 'required|integer|exists:canchas,id_cancha',
                'fecha' => 'required|date',
                'hora' => 'required|string',
                'estado' => 'required|string',
            ]);

            // Busca la disponibilidad y actualízala
            $disponibilidad = Disponibilidad::findOrFail($id);
            $disponibilidad->update($data);

            return response()->json($disponibilidad, 200);
        } catch (\Exception $e) {
            // Si ocurre un error al actualizar, devuelve un mensaje de error
            return response()->json(['error' => 'Error al actualizar disponibilidad'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Busca y elimina la disponibilidad
            $disponibilidad = Disponibilidad::findOrFail($id);
            $disponibilidad->delete();

            return response()->json(['message' => 'Disponibilidad eliminada correctamente'], 200);
        } catch (\Exception $e) {
            // Si ocurre un error al eliminar, devuelve un mensaje de error
            return response()->json(['error' => 'Error al eliminar disponibilidad'], 500);
        }
    }
}
