<?php
namespace App\GraphQL\Mutations;

use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Disponibilidad;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateCanchaConReservas
{
    public function __invoke($_, array $args)
    {
        return DB::transaction(function () use ($args) {
            $input = $args['input'];

            // 1. Crear la cancha
            $cancha = Cancha::create([
                'nombre' => $input['nombre'],
                'ubicacion' => $input['ubicacion'] ?? null,
                'tipo' => $input['tipo'] ?? null,
            ]);

            // 2. Crear disponibilidades basadas en reservas
            $this->crearDisponibilidadesIniciales($cancha, $input['reservas'] ?? []);

            // 3. Procesar reservas
            if (!empty($input['reservas'])) {
                foreach ($input['reservas'] as $reservaData) {
                    $this->procesarReserva($cancha, $reservaData);
                }
            }

            return $cancha->load('reservas');
        });
    }

    protected function procesarReserva($cancha, $reservaData)
    {
        // Asegurar formato correcto
        $fecha = Carbon::parse($reservaData['fecha_reserva'])->format('Y-m-d');
        $hora = Carbon::parse($reservaData['hora_reserva'])->format('H:i:s');

        // Buscar disponibilidad EXACTA
        $disponibilidad = Disponibilidad::where('id_cancha', $cancha->id_cancha)
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->where('estado', 'disponible')
            ->first();

        if (!$disponibilidad) {
            // Debug avanzado
            $existe = Disponibilidad::where('id_cancha', $cancha->id_cancha)
                ->where('fecha', $fecha)
                ->where('hora', $hora)
                ->exists();

            throw new Exception(
                $existe 
                ? "El horario existe pero está ocupado" 
                : "No existe el horario $fecha $hora para esta cancha"
            );
        }

        // Crear reserva
        $cancha->reservas()->create([
            'id_usuario' => $reservaData['id_usuario'],
            'fecha_reserva' => $fecha,
            'hora_reserva' => $hora,
        ]);

        // Actualizar disponibilidad
        $disponibilidad->update(['estado' => 'ocupado']);
    }

    protected function crearDisponibilidadesIniciales(Cancha $cancha, array $reservas = [])
    {
        $horarios = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'];

        // Calcular el rango de fechas a partir de reservas si existen
        $fechaInicio = now();
        $fechaFin = now()->addDays(30);

        if (!empty($reservas)) {
            $fechas = array_map(fn($r) => Carbon::parse($r['fecha_reserva']), $reservas);
            $fechaInicio = collect($fechas)->min()->copy()->subDays(1);
            $fechaFin = collect($fechas)->max()->copy()->addDays(1);
        }

        $disponibilidades = [];
        $fecha = $fechaInicio->copy();

        while ($fecha->lessThanOrEqualTo($fechaFin)) {
            foreach ($horarios as $hora) {
                $disponibilidades[] = [
                    'id_cancha' => $cancha->id_cancha,
                    'fecha' => $fecha->format('Y-m-d'),
                    'hora' => $hora,
                    'estado' => 'disponible',
                ];
            }
            $fecha->addDay();
        }

        // Insertar en lote
        Disponibilidad::insert($disponibilidades);
    }
}
