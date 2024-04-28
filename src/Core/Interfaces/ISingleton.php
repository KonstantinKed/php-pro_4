<?php


namespace App\Core\Interfaces;

interface ISingleton
{
    public static function getInstance(): self;
}
