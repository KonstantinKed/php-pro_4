<?php


namespace App\Core\Web\VO;

use Attribute;
use App\Core\Exceptions\ParameterNotFoundException;
use JetBrains\PhpStorm\Pure;

#[Attribute] class Params
{
    /**
     * @var Param[]
     */
    protected array $params = [];

    #[Pure] public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = new Param($key, $value);
        }
    }

    /**
     * @return Param[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isParam(string $name): bool
    {
        return isset($this->params[$name]);
    }

    /**
     * @param string $name
     * @return Param
     */
    public function getParam(string $name): Param
    {
        if (!$this->isParam($name)) {
            throw new ParameterNotFoundException();
        }
        return $this->params[$name];
    }
}