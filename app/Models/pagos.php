<?php
// app/Models/Pagos.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    // Especificamos la tabla
    protected $table = 'pagos';

    // Especificamos la clave primaria si no es 'id'
    protected $primaryKey = 'id_pago';

    // Definimos qué columnas pueden ser asignadas masivamente
    protected $fillable = [
        'id_reserva',
        'monto',
        'metodo_pago',
        'fecha_pago',
    ];

        public $timestamps = false;
}
