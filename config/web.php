<?php


use App\Calculator\Calculator;
use App\Controllers\CalcController;
use App\Controllers\ErrorController;
use App\Controllers\UserController;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;
use App\ORM\ActiveRecord\DatabaseAR;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Capsule\Manager;


return [

    UserController::class => [
        S::CLASSNAME => UserController::class,
        S::ARGUMENTS => [
            '@' . EntityManager::class,
        ],
    ],
    CalcController::class => [
        S::CLASSNAME => CalcController::class,
        S::ARGUMENTS => [
            '@' . Calculator::class,
        ],
    ],
    ErrorController::class => [
        S::CLASSNAME => ErrorController::class,
    ],
];
