<?php

const TAXES_NAME = 'taxes';
const TAXES_FORMAT_DETECT = 1;

const POSITIVE_PREDICTION = [
    "Ви досягнете великого успіху в найближчому майбутньому.",
    "Ваші зусилля скоро будуть винагороджені.",
    "Очікуйте приємних змін у вашому житті.",
    "Ви знайдете нові можливості для зростання та розвитку."
];


interface PNL {
    public function grossProfit(): int;
    public function operationalIncome(): int;
    public function netIncome(): int;
    public function result(): void;
}


class IncomeData {
    public function __construct(protected string $revenue, protected string $costGoodsSold,
                                protected string $operationalExpenses, protected string $taxRate)
    {
        IncomeValidator::validateAll($this);
    }

    public function getRevenue(): string
    {
        return $this->revenue;
    }

    public function getCostGoodsSold(): string
    {
        return $this->costGoodsSold;
    }

    public function getOperationalExpenses(): string
    {
        return $this->operationalExpenses;
    }

    public function getTaxRate(): string
    {
        return $this->taxRate;
    }
}

//class IncomeData {
//    protected array $data;
//    public function __construct(string $revenue, string $cogs, string $operationalExpenses, string $taxes)
//    {
//        $this->data = [
//            'revenue' => $revenue,
//            'cogs' => $cogs,
//            'operationalExpenses' => $operationalExpenses,
//            'taxes' => $taxes,
//        ];
//        IncomeValidator::validateAll($this->data);
//    }
//    public function getData(): array
//    {
//        return $this->data;
//    }
//}

class IncomeValidator {
    public static function validateAll(IncomeData $data) {
        $objectToArray = [
            'revenue' => $data->getRevenue(),
            'cogs' => $data->getCostGoodsSold(),
            'operationalExpenses' => $data->getOperationalExpenses(),
            'taxes' => $data->getTaxRate(),
        ];
        foreach ($objectToArray as $key => $value) {
            self::validateInputNumeric($value, $key);
        }
    }
    public static function validateInputNumeric(string $input, string $inputName): void {
        if (empty($input)) {
            throw new InvalidArgumentException("Please insert {$inputName}.");
        }
        if (!is_numeric($input)) {
            throw new InvalidArgumentException("{$inputName} must be a numeric value.");
        }
    }
}

class SimpleCalculation implements PNL {
    public function __construct(protected IncomeData $data){}
    public function grossProfit (): int {
        return round($this->data->getRevenue() - $this->data->getCostGoodsSold());
    }
    public function operationalIncome(): int {
        return round($this->data->getRevenue() - $this->data->getCostGoodsSold() - $this->data->getOperationalExpenses());
    }
    public function netIncome(): int {
        return round($this->data->getRevenue() - $this->data->getCostGoodsSold() -
            $this->data->getOperationalExpenses() - ($this->data->getRevenue() - $this->data->getCostGoodsSold() -
                $this->data->getOperationalExpenses())*$this->data->getTaxRate()/100);
    }

    public function result (): void {
        echo "=======SIMPLE CALCULATION==========" . PHP_EOL .
        "Your company details:
              - gross profit: {$this->grossProfit()}
              - operationalIncome: {$this->operationalIncome()}
              - netIncome: {$this->netIncome()}". PHP_EOL;
    }

}

class CompactCalculation extends SimpleCalculation {
    public function operationalIncome(): int {
        return round($this->grossProfit() - $this->data->getOperationalExpenses());
    }
    public function netIncome(): int {
            return round($this->operationalIncome() - parent::operationalIncome() * $this->data->getTaxRate()/100);
    }
    public function result (): void {
        echo "=======COMPACT CALCULATION==========" . PHP_EOL .
            "Your entered the following data:
              - Revenue: {$this->data->getRevenue()}
              - CostGoodsSold: {$this->data->getCostGoodsSold()}
              - OperationalExpenses: {$this->data->getOperationalExpenses()}
              - Taxes: {$this->data->getTaxRate()}" . PHP_EOL
            . "Your company details:
              - gross profit: {$this->grossProfit()}
              - operationalIncome: {$this->operationalIncome()}
              - netIncome: {$this->netIncome()}". PHP_EOL;
    }
}


// Покращенний метод враховує можливість введення податків не тільки в абсолютній формі, а і в десятковому форматі.

class ImprovedCalculation implements PNL {

    public function __construct(protected IncomeData $data) {}

    public function grossProfit(): int
    {
        return round($this->data->getRevenue() - $this->data->getCostGoodsSold());
    }
    public function operationalIncome(): int
    {
        return round($this->grossProfit() - $this->data->getOperationalExpenses());
    }
    public function netIncome(): int
    {
        if ($this->isTaxInPercent()) {
            return round($this->operationalIncome()*(1 - $this->data->getTaxRate()/100));
        }
        return round($this->operationalIncome()*(1 - $this->data->getTaxRate()));
    }
    public function isTaxInPercent ():bool {
        return $this->data->getTaxRate() > TAXES_FORMAT_DETECT;
    }
    public function randomPrediction () {
        return array_rand(array_flip(POSITIVE_PREDICTION));

}
    public function result(): void {
        echo "=======IMPROVED CALCULATION==========" . PHP_EOL .
            "Your entered the following data:
              - Revenue: {$this->data->getRevenue()}
              - CostGoodsSold: {$this->data->getCostGoodsSold()}
              - OperationalExpenses: {$this->data->getOperationalExpenses()}
              - Taxes: {$this->data->getTaxRate()}" . PHP_EOL
            . "Your company details:
              - gross profit: {$this->grossProfit()}
              - operationalIncome: {$this->operationalIncome()}
              - netIncome: {$this->netIncome()}" . PHP_EOL .
        "PREDICTION FOR YOU: {$this->randomPrediction()}";
    }
}

$comFirstDetails = new IncomeData("10000","100",500, 20);
$comSecondDetails = new IncomeData("10000","100",500, 0.2);
//$simpleResult = new SimpleCalculation($comFirstDetails);
$simpleResult = new SimpleCalculation($comSecondDetails);
//$compactResult = new CompactCalculation($comFirstDetails);
$compactResult = new CompactCalculation($comSecondDetails);
$improvedResult1 = new ImprovedCalculation($comFirstDetails);
$improvedResult2 = new ImprovedCalculation($comSecondDetails);


echo $simpleResult->result() . PHP_EOL;
echo $compactResult->result() . PHP_EOL;
//echo $improvedResult1->result() . PHP_EOL;
echo $improvedResult2->result() . PHP_EOL;

exit;


//SimpleCalculation, CompactCalculation та ImprovedCalculation поліморфні між собою по методам
// operationalIncome(), netIncome() та result() завдяки інтерфейсу.
// ПИТАННЯ:
// А) Чи правильно я розумію, що по методу grossProfit() немає поліморфності, тому що його реалізація не змінюється?
// Б) Чи є можливість не переписувати однакову реалізацію методу для класів, що мають спільний інтерфейс?


// SimpleCalculation, CompactCalculation поліморфні між собою по методам
// operationalIncome(), netIncome() та result() завдяки наслідуванню.





