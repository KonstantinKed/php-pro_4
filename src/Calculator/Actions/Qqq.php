<?php


namespace App\Calculator\Actions;


class Qqq extends AbstractAction
{
    const SIGNATURE = '!';

    public function calculate(int|float $val1, int|float $val2): int|float
    {
        return $val1 * $val2;
    }
}
