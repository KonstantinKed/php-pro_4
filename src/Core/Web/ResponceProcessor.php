<?php

namespace App\Core\Web;

use JetBrains\PhpStorm\NoReturn;
use Psr\Http\Message\ResponseInterface;

class ResponseProcessor
{
    protected static ResponseInterface $response;

    #[NoReturn] public static function processing(
        ResponseInterface $response,
        ?callable         $callback = null
    ): void
    {
        static::$response = $response;

        if (!headers_sent()) {
            static::sendHeaders();
        }
        static::sendContent();

        if (is_callable($callback)) {
            $callback($response);
        }
        exit;
    }

    /**
     * Sends HTTP headers.
     */
    protected static function sendHeaders(): void
    {
        $r = static::$response;
        foreach ($r->getHeaders() as $name => $values) {
            $replace = 0 === strcasecmp($name, 'Content-Type');
            foreach ($values as $value) {
                header($name . ': ' . $value, $replace, $r->getStatusCode());
            }
        }

        // status
        header(
            sprintf(
                'HTTP/%s %s',
                $r->getProtocolVersion(),
                $r->getStatusCode()
            ),
            true,
            $r->getStatusCode()
        );
    }

    /**
     * Sends content for the current Web response.
     */
    protected static function sendContent(): void
    {
        echo static::$response->getBody();
    }
}