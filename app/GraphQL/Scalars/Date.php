<?php

namespace App\GraphQL\Scalars;

use Carbon\Carbon;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Language\AST\Node;

class Date extends ScalarType
{
    public string $name = 'Date';

    public function serialize($value): string
    {
        return $value instanceof Carbon
            ? $value->format('Y-m-d')
            : (new Carbon($value))->format('Y-m-d');
    }

    public function parseValue($value): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', $value);
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null): Carbon
    {
        if ($valueNode instanceof StringValueNode) {
            return Carbon::createFromFormat('Y-m-d', $valueNode->value);
        }

        throw new \InvalidArgumentException("El valor no es un nodo de tipo StringValueNode.");
    }
}
