<?php
namespace App\Calculator;



class SmartCalculator extends Calculator
{
    public function calculateExpression(string $exp): float|int
    {
        $data = explode(' ', $exp);
        new NumberValidator($data[0]);
        new NumberValidator($data[2]);

        return $this->calculate($data[0], $data[2], $data[1]);
    }
}
