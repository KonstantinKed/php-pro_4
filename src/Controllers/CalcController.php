<?php

namespace App\Controllers;

use App\Calculator\Calculator;
use App\Core\Web\Interfaces\IWebController;
use App\Core\Web\VO\Route;

class CalcController implements IWebController
{
    public function __construct(
        protected Calculator $calc
    )
    {
    }

    #[Route('/calc')]
    public function action(int $a, string $action, int $b): string
    {
        return 'result: ' . $this->calc->calculate($a, $b, $action);
    }
}
