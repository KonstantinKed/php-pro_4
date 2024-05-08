<?php


namespace App\Calculator\Interfaces;


interface ICanCalculate
{
    public function calculate(int|float $val1, int|float $val2): int|float;

    public static function getSignature(): string;

}
