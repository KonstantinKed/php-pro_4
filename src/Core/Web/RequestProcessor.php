<?php


namespace App\Core\Web;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestProcessor
{
    protected static ?RequestInterface $request = null;

    public static function getCurrentRequest(): RequestInterface
    {
        if (is_null(static::$request)) {
            static::$request = new Request(
                $_SERVER['REQUEST_METHOD'],
                $_SERVER['REQUEST_URI'],
                getallheaders(),
                file_get_contents('php://input'),
                last(explode('/', $_SERVER['SERVER_PROTOCOL']))
            );
        }
        return static::$request;
    }
}
