<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_usuario',
        'id_cancha',
        'fecha_reserva',
        'hora_reserva',
    ];

    public $timestamps = false;

    /**
     * Relación con cancha.
     */
    public function cancha(): BelongsTo
    {
        return $this->belongsTo(Cancha::class, 'id_cancha');
    }

    /**
     * Relación con usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Busca una reserva por ID o lanza error.
     */
    public static function buscarOError(int $id): self
    {
        try {
            return self::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception("La reserva con ID $id no fue encontrada.", 404);
        }
    }
}
