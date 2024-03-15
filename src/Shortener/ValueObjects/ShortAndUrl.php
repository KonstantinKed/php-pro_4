<?php

namespace App\Shortener\ValueObjects;

class ShortAndUrl
{

    public function __construct(protected string $url, protected string $short = '') {}

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setShort(string $short): void
    {
        $this->short = $short;
    }

    public function getShort(): string
    {
        return $this->short;
    }
}