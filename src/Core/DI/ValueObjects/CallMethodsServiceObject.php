<?php


namespace App\Core\DI\ValueObjects;

class CallMethodsServiceObject
{

    /**
     * @param ServiceObject $serviceObject
     * @param string $method
     * @param array $arguments
     */
    public function __construct(
        protected ServiceObject $serviceObject,
        protected string        $method,
        protected array         $arguments
    )
    {
    }

    /**
     * @return ServiceObject
     */
    public function getServiceObject(): ServiceObject
    {
        return $this->serviceObject;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments ?? [];
    }

}
