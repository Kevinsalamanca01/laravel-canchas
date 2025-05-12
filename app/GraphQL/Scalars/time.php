<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\StringValueNode;
use Carbon\Carbon;

class Time extends ScalarType
{
    public string $name = 'Time';

    public function serialize($value)
    {
        return $value instanceof \DateTimeInterface
            ? $value->format('H:i:s')
            : $value;
    }

    public function parseValue($value)
    {
        return Carbon::createFromFormat('H:i:s', $value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if ($valueNode instanceof StringValueNode) {
            return Carbon::createFromFormat('H:i:s', $valueNode->value);
        }

        throw new \InvalidArgumentException('Invalid time format');
    }
}
