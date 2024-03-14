<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use App\Shortener\Interfaces\IUrlValidator;
use App\Shortener\SuportActions\CodeFileSaver;
use App\Shortener\SuportActions\CodeGenerator;
use InvalidArgumentException;
use JsonException;
use Random\RandomException;

class UrlEncodeDecode implements IUrlEncoder, IUrlDecoder
{

    public function __construct(protected IUrlValidator $validator,
                                protected CodeGenerator $generator,
                                protected CodeFileSaver $codeSaver){}

    /**
     * @inheritDoc
     * @throws RandomException
     * @throws JsonException
     */
    public function encode(string $url): string
    {
        $this->validator->isValidUrl($url);
        $this->validator->isExistUrl($url);

        // Залишу цю частину коду закоментованим, як моє самостійне рішення. Варіант використати throw замість if -
        // елегантний, та все ж запозичений у тебе! Але тепер зрозуміло навіщо потрібно створювати кастомний exception!
//        if ($this->saver->getCodeByUrl($url)) {
//            return $this->saver->getCodeByUrl($url);
//        }
//        $shortAndUrl = $this->generator->generateCode($url);;
//        $this->saver->saveShortAndUrl($shortAndUrl);

        try {
            $this->codeSaver->getCodeByUrl($url);
        } catch (DataNotFoundException $e) {
            $shortAndUrl = $this->generator->generateCode($url);;
            $this->codeSaver->saveShortAndUrl($shortAndUrl);
        }
        return $shortAndUrl->getShort();

    }

    /**
     * @throws JsonException
     */
    public function decode(string $code): string
    {
        try {
            $url = $this->codeSaver->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new InvalidArgumentException(
                $e->getMessage()
            );
        }
        return $url;
    }

}