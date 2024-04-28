<?php

namespace App\Core\DI\Enums;

enum RefResolver: string
{
    case ServiceOrParameter = "get";
    case Tag = "getByTag";

    public static function getReferenceByName(string $name): string
    {
        return constant("self::$name")->value;
    }

    public static function getTypeReference(string $type): RefResolver
    {
        return match ($type) {
            '@', '%' => self::ServiceOrParameter,
            '$' => self::Tag,
        };
    }
}
