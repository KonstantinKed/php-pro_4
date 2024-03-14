<?php

namespace App\Shortener\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function isValidUrl(string $url): bool;
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function isExistUrl(string $url): bool;

}