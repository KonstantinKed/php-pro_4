<?php


namespace App\ORM\DataMapper\VO;

#[\Attribute] class PrivateProperties
{
    /**
     * @param Property[] $properties
     */
    protected array $properties;

    public function __construct(array $properties)
    {
        foreach ($properties as $value) {
            $this->properties[$value] = new Property($value, true);
        }
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getProperty(string $name): ?Property
    {
        return $this->properties[$name] ?? null;
    }


}