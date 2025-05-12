<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
    ];

   
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }
}
