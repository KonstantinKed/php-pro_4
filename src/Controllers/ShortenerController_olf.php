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

class ShortenerController_olf implements IWebController
{
    /**
     * @var ShortenerRepository
     */
    protected EntityRepository $shortenerRepo;

    public function __construct(
        protected EntityManager $em)
    {
//        $this->userRepo = $this->em->getRepository(User::class);
        $this->shortenerRepo = $this->em->getRepository(Shortener::class);
    }

    /**
     * @throws RandomException
     */
    public function action(string $url): string {
        $urlValidator = new SimpleUrlValidator(new Client());
        $codeGenerator = new CodeGenerator();
        $result = new UrlEncodeDecode($urlValidator, $codeGenerator, $this->shortenerRepo);
        return 'Скорочений код: ' . $result->encode($url);
    }






}