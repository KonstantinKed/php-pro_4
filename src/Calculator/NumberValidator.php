<?php
namespace App\Calculator;

use InvalidArgumentException;

class NumberValidator
{
    protected int|float $value;

    public function __construct($value)
    {
        $this->isNumber($value);
        $this->value = $value;
    }

    protected function isNumber($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException($value . ' - is not a number');
        }
    }
}
