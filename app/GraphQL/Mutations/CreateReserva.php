<?php

namespace App\GraphQL\Mutations;

use App\Models\Reserva;
use App\Models\Disponibilidad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Carbon\Carbon;

class CreateReserva
{
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        // Log de inicio
        Log::info('Mutación CreateReserva ejecutada');
        Log::info('Datos recibidos:', $args);

        // Normalización de fecha y hora
        if (isset($args['fecha_reserva'])) {
            $args['fecha_reserva'] = Carbon::parse($args['fecha_reserva'])->format('Y-m-d');
        }
        if (isset($args['hora_reserva'])) {
            $args['hora_reserva'] = Carbon::parse($args['hora_reserva'])->format('H:i:s');
        }

        // Validación de los datos
        $validator = Validator::make($args, [
            'id_cancha'    => 'required|integer|exists:canchas,id_cancha',
            'id_usuario'   => 'required|integer|exists:usuarios,id_usuario',
            'fecha_reserva'=> 'required|date|after_or_equal:today',
            'hora_reserva' => 'required|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            throw new \Exception(json_encode($validator->errors()->all()));
        }

        // Verificación de disponibilidad
        $disponibilidad = Disponibilidad::where('id_cancha', $args['id_cancha'])
            ->where('fecha', $args['fecha_reserva'])
            ->where('hora', $args['hora_reserva'])
            ->whereIn('estado', ['libre', 'disponible'])
            ->first();

        if (!$disponibilidad) {
            throw new \Exception("No hay disponibilidad para la fecha y hora seleccionadas.");
        }

        // Actualización del estado a "ocupado"
        $disponibilidad->estado = 'ocupado';
        $disponibilidad->save();

        // Creación de la reserva
        return Reserva::create([
            'id_cancha'    => $args['id_cancha'],
            'id_usuario'   => $args['id_usuario'],
            'fecha_reserva'=> $args['fecha_reserva'],
            'hora_reserva' => $args['hora_reserva'],
        ]);
    }
}
