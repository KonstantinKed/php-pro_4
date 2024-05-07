<?php


namespace App\Core\Web\VO;

class Param
{

    public function __construct(protected string $name, protected string $value)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
