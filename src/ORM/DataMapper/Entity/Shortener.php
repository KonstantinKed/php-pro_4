<?php

namespace App\ORM\DataMapper\Entity;


use App\ORM\DataMapper\Repositories\ShortenerRepository;
use App\ORM\DataMapper\Traits\JsonSerializableTrait;
use App\ORM\DataMapper\VO\PrivateProperties;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShortenerRepository::class)]
#[ORM\Table(name: 'shortener')]
#[PrivateProperties(['password', 'phones', 'status'])]
class Shortener implements \JsonSerializable
{
    use JsonSerializableTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $url;

    #[ORM\Column(length: 20)]
    private string $short_code;


    /**
     * @param string $url
     * @param string $short_code
     */
    public function __construct(string $url, string $short_code)
    {
        $this->url = $url;
        $this->short_code = $short_code;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getShortCode(): string
    {
        return $this->short_code;
    }

    public function setShortCode(string $short_code): void
    {
        $this->short_code = $short_code;
    }


}
