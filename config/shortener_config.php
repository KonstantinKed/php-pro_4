<?php

use App\Core\DI\Container;
use App\Shortener\UrlEncodeDecode;

return [
    UrlEncodeDecode::class => [
        S::CLASSNAME => UrlEncodeDecode::class,
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