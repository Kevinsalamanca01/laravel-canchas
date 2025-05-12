<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Disponibilidad;
use App\Models\Reserva; 


class Cancha extends Model
{
    use HasFactory;

    protected $table = 'canchas'; 
    protected $primaryKey = 'id_cancha';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'tipo',
    ];

    public $timestamps = false;

    /**
     
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_cancha');
    }

    /**
     * 
     */
    public static function buscarOError(int $id): self
    {
        try {
            return self::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception("La cancha con ID $id no fue encontrada.", 404);
        }
    }

    
    public function disponibilidad(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_cancha');
    }
}