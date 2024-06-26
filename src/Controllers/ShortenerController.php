<?php

namespace App\Controllers;

use App\Core\Web\Interfaces\IWebController;
use App\Core\Web\VO\Route;
use App\ORM\DataMapper\Entity\Shortener;

use App\ORM\DataMapper\Repositories\ShortenerRepository;

use App\Shortener\SuportActions\CodeGenerator;
use App\Shortener\SuportActions\SimpleUrlValidator;
use App\Shortener\UrlEncodeDecode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GuzzleHttp\Client;
use Random\RandomException;

class ShortenerController implements IWebController
{
    /**
     * @var ShortenerRepository
     */
    protected UrlEncodeDecode $urlEncodeDecode;
    protected EntityRepository $shortenerRepo;
    protected SimpleUrlValidator $validator;
    protected CodeGenerator $generator;

    public function __construct(
        protected EntityManager $em)
    {
        $this->shortenerRepo = $this->em->getRepository(Shortener::class);
    }

    /**
     * @throws RandomException
     */
    public function action(string $url): string {
        $result = new UrlEncodeDecode($this->validator, $this->generator, $this->shortenerRepo);
        return 'Скорочений код: ' . $result->encode($url);
    }


    public function urlValidator()
    {
        return $this->validator = new SimpleUrlValidator(new Client());
    }

    public function codeGenarator()
    {
        return $this->generator = new CodeGenerator();
    }

//    public function urlEncodeDecode()
//    {
//        return $this->urlEncodeDecode = new UrlEncodeDecode($this->validator, $this->generator, $this->shortenerRepo);
//    }

}