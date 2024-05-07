<?php


namespace App\Commands;

use App\Calculator\Calculator;
use App\Core\CLI\Commands\AbstractCommand;

class CalculatorCommand extends AbstractCommand
{
    const NAME = 'calc';

    public function __construct(protected Calculator $calculator)
    {
    }

    public static function getCommandDesc(): string
    {
        return 'Simple cli calculator';
    }

    protected function runAction(): string
    {
        try {
            $result = 'Result: ' . $this->calculator->calculate($this->getParam(0), $this->getParam(2), $this->getParam(1));
        } catch (\Throwable $e) {
            $result = 'OOPS!!! Error: ' . $e->getMessage() . PHP_EOL;
            $result .= 'Format: [num] [action] [num] (2 + 2)' . PHP_EOL;
            $result .= 'Actions: ' . implode(', ', $this->calculator->getCalculatePossibilities());
        }
        return $result;
    }
}