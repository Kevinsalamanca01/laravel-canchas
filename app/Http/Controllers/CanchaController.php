<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class CanchaController extends Controller
{
    /**
     * Muestra todas las canchas con sus reservas.
     */
    public function index(): JsonResponse
    {
        $canchas = Cancha::with('reservas')->get();
        return response()->json($canchas, 200);
    }

    /**
     * Crea una nueva cancha.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
        ]);

        try {
            $cancha = Cancha::create($validated);
            return response()->json($cancha, 201); // Recurso creado
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear la cancha.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra una cancha específica con sus reservas.
     */
    public function show($id): JsonResponse
    {
        try {
            $cancha = Cancha::with('reservas')->findOrFail($id);
            return response()->json($cancha, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cancha no encontrada.'], 404);
        }
    }

    /**
     * Actualiza los datos de una cancha existente.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $cancha = Cancha::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:100',
                'ubicacion' => 'sometimes|required|string|max:100',
                'tipo' => 'sometimes|required|string|max:50',
            ]);

            $cancha->update($validated);
            return response()->json($cancha, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cancha no encontrada.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la cancha.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina una cancha por su ID.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $cancha = Cancha::findOrFail($id);
            $cancha->delete();
            return response()->json(['mensaje' => 'Cancha eliminada correctamente.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cancha no encontrada.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar la cancha.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
