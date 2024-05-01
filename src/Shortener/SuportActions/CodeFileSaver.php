<?php

namespace App\Shortener\SuportActions;

use App\Shortener\Exceptions\DataNotFoundException;
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
//    public function saveShortAndUrl(ShortAndUrl $shortAndUrl): bool
//    {
//        $data = $this->readData();
//        $data[$shortAndUrl->getShort()] = $shortAndUrl->getUrl();
//        return (file_put_contents($this->filePath, json_encode($data)));
//
//    }
//
    public function saveShortAndUrl(string $url, string $code): bool
    {
        $data = $this->readData();
        $data[$url] = $code;
        return (file_put_contents($this->filePath, json_encode($data)));

    }


    /**
     * @throws JsonException
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = (file_get_contents($this->filePath));
        $data = json_decode($data, true);
        if (!$code = array_search($url, $data, true)) {
            throw new DataNotFoundException();
        }

        return $code;
    }
    /**
     * @throws JsonException
     */
    public function getUrlByCode(string $code): ?string {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $data = file_get_contents($this->filePath);
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        print_r($data);
        if (!$url = array_search($code, $data, true)) {
            throw new DataNotFoundException();
        }

        return $url;


    }

}