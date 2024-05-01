<?php

namespace App\Shortener\Interfaces;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\ValueObjects\ShortAndUrl;
use JsonException;

interface ICodeSaver
{
//    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool;

    public function saveShortAndUrl(string $url, string $code): bool;

    /**
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): ?string;
    public function getUrlByCode(string $code): ?string;
}