<?php


use App\Calculator\Calculator;
use App\Calculator\SmartCalculator;
use App\Commands\CalculatorCommand;
use App\Commands\TestCommand;
use App\Commands\UrlDecodeCommand;
use App\Commands\UrlEncodeCommand;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;

return [
    // ----------- COMMANDS -----------

    "cli.command.test" => [
        S::CLASSNAME => TestCommand::class,
        S::TAGS => ['cli.command']
    ],
    "cli.command.urlEncode" => [
        S::CLASSNAME => UrlEncodeCommand::class,
        S::ARGUMENTS => [
            '@shortener.converter'
        ],
        S::TAGS => ['cli.command', 'allowed.command']
    ],
    "cli.command.urlDecode" => [
        S::CLASSNAME => UrlDecodeCommand::class,
        S::ARGUMENTS => [
            '@shortener.converter'
        ],
        S::TAGS => ['cli.command', 'allowed.command']
    ],
    "cli.command.calculator" => [
        S::CLASSNAME => CalculatorCommand::class,
        S::ARGUMENTS => [
            '@' . SmartCalculator::class
        ],
        S::TAGS => ['cli.command', 'allowed.command']
    ],

];
