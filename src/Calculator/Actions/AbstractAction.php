<?php
namespace App\Calculator\Actions;


use App\Calculator\Interfaces\ICanCalculate;

abstract class AbstractAction implements ICanCalculate
{
    const SIGNATURE = '';

    public static function getSignature(): string
    {
        return static::SIGNATURE;
    }
}
