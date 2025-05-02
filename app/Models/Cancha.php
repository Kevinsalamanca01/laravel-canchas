<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_cancha');
    }
}
