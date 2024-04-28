<?php


namespace App\Calculator;


use App\Calculator\Interfaces\ICanCalculate;

class Calculator
{
    /**
     * @var ICanCalculate[]
     */
    protected array $calculatePossibilities = [];

    public function calculate(mixed $val1, mixed $val2, string $operator): int|float
    {
        $operator = trim($operator);
        new NumberValidator($val1);
        new NumberValidator($val2);
        if (!isset($this->calculatePossibilities[$operator])) {
            throw new \InvalidArgumentException('The operation "' . $operator . '" is impossible');
        }
        return $this->calculatePossibilities[$operator]->calculate($val1, $val2);
    }

    public function actionRegistration(ICanCalculate $action): static
    {
        $this->calculatePossibilities[$action::getSignature()] = $action;
        return $this;
    }

    /**
     * @param ICanCalculate[] $actions
     * @return $this
     */
    public function actionsRegistration(array $actions): static
    {
        foreach ($actions as $action) {
            $this->actionRegistration($action);
        }
        return $this;
    }

    public function getCalculatePossibilities(): array
    {
        return array_keys($this->calculatePossibilities);
    }
}
