<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí puedes poner la lógica de autorización si la necesitas
        return true; // Por ahora, permitimos a cualquier usuario realizar la solicitud
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cancha_id' => 'required|exists:canchas,id', // La cancha debe existir en la base de datos
            'fecha' => 'required|date|after_or_equal:today', // La fecha debe ser válida y no puede ser pasada
            'hora_inicio' => 'required|date_format:H:i', // La hora de inicio debe tener el formato HH:mm
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // La hora de fin debe ser posterior a la de inicio
            'cliente' => 'required|string|max:100', // El nombre del cliente no debe exceder los 100 caracteres
        ];
    }
}
