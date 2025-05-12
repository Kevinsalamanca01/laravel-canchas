<?php

namespace App\GraphQL\Resolvers;

use App\Models\Usuario;

class UsuarioResolver
{
    public function resolve()
    {
        return Usuario::all();  
    }
}
