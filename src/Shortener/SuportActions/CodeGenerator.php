<?php

namespace App\Shortener\SuportActions;

use Random\RandomException;

class CodeGenerator
{
    const DEFAULT_CODE_LENGTH = 8;
    public function __construct(protected string $url,  protected string $length = self::DEFAULT_CODE_LENGTH)
    {
    }

    /**
     * @throws RandomException
     */
    public function generateCode(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);
        $pathParts = explode('/', trim($path, '/'));
        $resourceName = end($pathParts);
        if (strlen($resourceName) > 3) {
            $mix = $resourceName[0] . $resourceName[2] . substr($resourceName, -1);
        } else {
            $mix = str_pad($resourceName, 3, '_');
        }
        $randomData = random_bytes(10);
        $hash = hash('sha256', $mix . $randomData);
        return substr($hash, 0, $this->length);
    }
}