<?php


use App\Calculator\Actions\Div;
use App\Calculator\Actions\Expo;
use App\Calculator\Actions\Multi;
use App\Calculator\Actions\Sub;
use App\Calculator\Actions\Sum;
use App\Calculator\Calculator;
use App\Calculator\SmartCalculator;
use App\Core\DI\Container;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;
use App\Core\DI\ValueObjects\ServiceObject;

return [
    Calculator::class => [
        S::CLASSNAME => Calculator::class,
        S::COMPILER => function (Container $container, object $object, ServiceObject $refs) {
            /**
             * @var Calculator $object
             */
            foreach ($container->getByTag('calculator.action') as $item) {
                $object->actionRegistration($item);
            }
        },
    ],
    SmartCalculator::class => [
        S::CLASSNAME => SmartCalculator::class,
        S::CALLS => [
            [
                S::METHOD => 'actionsRegistration',
                S::ARGUMENTS => [
                    '$calculator.action',
                ]
            ]
        ]
    ],

    Sum::class => [
        S::CLASSNAME => Sum::class,
        S::TAGS => ['calculator.action']
    ],
    Sub::class => [
        S::CLASSNAME => Sub::class,
        S::TAGS => ['calculator.action']
    ],
    Div::class => [
        S::CLASSNAME => Div::class,
        S::TAGS => ['calculator.action']
    ],
    Multi::class => [
        S::CLASSNAME => Multi::class,
        S::TAGS => ['calculator.action']
    ],
    Expo::class => [
        S::CLASSNAME => Expo::class,
        S::TAGS => ['calculator.action']
    ],

];