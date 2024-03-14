<?php

namespace App\Shortener\SuportActions;

use App\Shortener\Interfaces\ICodeSaver;
use App\Shortener\ValueObjects\ShortAndUrl;
use JsonException;

class CodeFileSaver implements ICodeSaver
{
    public function __construct(protected string $filePath)
    {
    }


    /**
     * @throws JsonException
     */
    protected function readData(): array {
        return file_exists($this->filePath) ?
            json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR) : [];
    }

    /**
     * @throws JsonException
     */
    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool
    {
        $data = $this->readData();
        $data[$shortAndUrl->getShort()] = $shortAndUrl->getUrl();
        return (file_put_contents($this->filePath, json_encode($data)));

    }

    /**
     * @throws JsonException
     */
    public function getUrlByCode(string $code): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);

        return $data[$code] ?? null;
    }

    /**
     * @throws JsonException
     */
    public function getCodeByUrl(string $url): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);
        $code = array_search($url, $data, true);
        return $code ?: null;
    }

}