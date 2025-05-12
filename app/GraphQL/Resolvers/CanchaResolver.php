<?php
namespace App\GraphQL\Resolvers;

use App\Models\Cancha;

class CanchaResolver
{
    public function resolve($root, array $args)
    {
        $query = Cancha::query();

        if (isset($args['filter'])) {
            if (isset($args['filter']['nombre'])) {
                $query->where('nombre', 'like', '%' . $args['filter']['nombre'] . '%');
            }
            if (isset($args['filter']['ubicacion'])) {
                $query->where('ubicacion', 'like', '%' . $args['filter']['ubicacion'] . '%');
            }
            if (isset($args['filter']['tipo'])) {
                $query->where('tipo', 'like', '%' . $args['filter']['tipo'] . '%');
            }
        }

        return $query->get();
    }
}
