<?php


namespace App\Core\Web\VO;


use \Attribute;
use App\Core\Web\Interfaces\IWebController;

#[Attribute] class Route
{
    const M_GET = 'GET';
    const M_POST = 'POST';
    const DEFAULT_METHODS = [
        self::M_GET, self::M_POST
    ];
    protected array $parameters = [];

    public function __construct(
        protected string          $path,
        protected array           $httpMethods = self::DEFAULT_METHODS,
        protected ?IWebController $controller = null,
        protected ?string         $method = null
    )
    {
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->path;
    }

    /**
     * @return IWebController
     */
    public function getController(): IWebController
    {
        return $this->controller;
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
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @param mixed $parameter
     * @param string|null $key
     * @return void
     */
    public function addParameter(mixed $parameter, ?string $key = null): void
    {
        if (is_null($key)) {
            $this->parameters[] = $parameter;
        } else {
            $this->parameters[$key] = $parameter;
        }
    }

    /**
     * @return array
     */
    public function getHttpMethods(): array
    {
        return $this->httpMethods;
    }


}