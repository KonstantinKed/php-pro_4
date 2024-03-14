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
    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool
    {
        $data = file_exists($this->filePath) ? json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR) : [];

        // Додавання або оновлення коду з URL
        $data[$shortAndUrl->getShort()] = $shortAndUrl->getUrl();

        // Збереження оновленого масиву назад у файл
        file_put_contents($this->filePath, json_encode($data));
    }

    /**
     * @throws JsonException
     */
    public function getUrlbyCode(string $code): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->filePath), true, 512, JSON_THROW_ON_ERROR);

        return $data[$code] ?? null;
    }

    public function getCodeByUrl(string $url): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        $code = array_search($url, $data);
        return $code ?: null;
    }

}