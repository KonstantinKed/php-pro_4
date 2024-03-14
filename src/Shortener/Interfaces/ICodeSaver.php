<?php

namespace App\Shortener\Interfaces;

use App\Shortener\ValueObjects\ShortAndUrl;

interface ICodeSaver
{
    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool;

    // income object with data,
}