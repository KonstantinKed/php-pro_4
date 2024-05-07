<?php

namespace App\Controllers;

use App\Core\Web\Interfaces\IWebController;
use App\Core\Web\VO\Route;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorController implements IWebController
{
    #[Route('/500')]
    public function error500(): string
    {
        return 'server error';
    }

//    #[Route('/404')]
//    public function error404(RequestInterface $request): ResponseInterface
//    {
//        $uri = $request->getUri()->getPath();
//        return new Response(404,[], 'uri not found: ' . $uri);
//    }

    #[Route('/404')]
    public function error404(string $uri): string
    {
        return 'uri not found: ' . $uri;
    }
}

