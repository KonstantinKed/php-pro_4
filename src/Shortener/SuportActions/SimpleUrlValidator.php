<?php

namespace App\Shortener\SuportActions;

use App\Shortener\Interfaces\IUrlValidator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;


class SimpleUrlValidator implements IUrlValidator
{
    public function __construct(protected Client $client){}


    /**
     * @param string $url
     * @return true
     */
    public function isValidUrl(string $url): true
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Provided URL in not a valid URL $url");
        }
        return true;
    }

    /**
     * @param string $url
     * @return true
     * @throws GuzzleException
     */
    public function isExistUrl(string $url): true
    {
        try {
            $response = $this->client->request('HEAD', $url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode(),[200, 201, 301, 302]));
        } catch (ConnectException|ClientException $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode());
        }
    }
}