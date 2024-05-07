<?php

namespace App\ORM\DataMapper\VO;

class Property
{

    public function __construct(protected string $name, protected bool $private = true)
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
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->private;
    }

}