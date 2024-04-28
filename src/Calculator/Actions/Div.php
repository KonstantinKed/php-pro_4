<?php


namespace App\Calculator\Actions;

use App\Calculator\Interfaces\ICanCalculate;

class Div implements ICanCalculate
{

    public function calculate(float|int $val1, float|int $val2): int|float
    {
        if ($val2 == 0) {
            throw new \InvalidArgumentException('Division by zero');
        }
        return $val1 / $val2;
    }

    public static function getSignature(): string
    {
        return '/';
    }
}
