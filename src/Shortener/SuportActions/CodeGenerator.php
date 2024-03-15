<?php

namespace App\Shortener\SuportActions;

use App\Shortener\ValueObjects\ShortAndUrl;
use Random\RandomException;

class CodeGenerator
{
    public const DEFAULT_CODE_LENGTH = 8;
    public function __construct(
                                protected int $length = self::DEFAULT_CODE_LENGTH){}

    /**
     * @throws RandomException
     */
//    public function generateCode($url): ShortAndUrl {
//        $path = parse_url($url, PHP_URL_PATH);
//        $pathParts = explode('/', trim($path, '/'));
//        $resourceName = end($pathParts);
//        if (strlen($resourceName) > 3) {
//            $mix = $resourceName[0] . $resourceName[2] . substr($resourceName, -1);
//        } else {
//            $mix = str_pad($resourceName, 3, '_');
//        }
//        $randomData = random_bytes(10);
//        $hash = hash('sha256', $mix . $randomData);
//        $short = substr($hash, 0, $this->length);
////        $this->shortAndUrl->setShort($short);
////        $this->shortAndUrl->setUrl($this->url);
//        return $shortAndUrl;
//    }

    public function generateCode($url): string {
        $pathParts = explode('/', trim($url, '/'));
        $resourceName = end($pathParts);
        if (strlen($resourceName) > 3) {
            $mix = $resourceName[0] . $resourceName[2] . substr($resourceName, -1);
        } else {
            $mix = str_pad($resourceName, 3, '_');
        }
        $randomData = random_bytes(10);
        $hash = hash('sha256', $mix . $randomData);
        //        $this->shortAndUrl->setShort($short);
//        $this->shortAndUrl->setUrl($this->url);
        return substr($hash, 0, $this->length);
    }
}