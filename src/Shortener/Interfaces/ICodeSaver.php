<?php

namespace App\Shortener\Interfaces;

use App\Shortener\ValueObjects\ShortAndUrl;

interface ICodeSaver
{
//    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool;

    public function saveShortAndUrl(string $url, string $code): bool;

    // income object with data,
}