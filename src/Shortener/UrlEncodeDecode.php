<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeSaver;
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
                                protected ICodeSaver $codeSaver){}

    /**
     * @inheritDoc
     * @throws RandomException
     */
    public function encode(string $url): string
    {
        $this->validator->isValidUrl($url);
        $this->validator->isExistUrl($url);
        try {
            $code = $this->codeSaver->getCodeByUrl($url);
        } catch (DataNotFoundException) {
            $code = $this->generator->generateCode($url);
            $this->codeSaver->saveShortAndUrl($url, $code);
        }
        return $code;

    }



    /**
     * @throws JsonException
     * @throws InvalidArgumentException
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