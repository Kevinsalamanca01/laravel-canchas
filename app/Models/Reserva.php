<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    
    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'id_cancha');
    }

    
  // public function usuario()
// {
//     return $this->belongsTo(Usuario::class, 'id_usuario');
// }

}
