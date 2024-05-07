<?php

namespace App\ORM\DataMapper\Entity;


use App\ORM\DataMapper\Repositories\UserRepository;
use App\ORM\DataMapper\Traits\JsonSerializableTrait;
use App\ORM\DataMapper\VO\PrivateProperties;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[PrivateProperties(['password', 'phones', 'status'])]
class User implements \JsonSerializable
{
    use JsonSerializableTrait;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_VIP = 2;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length: 60)]
    private string $login;

    #[ORM\Column(length: 32)]
    private string $password;

    #[ORM\OneToMany(targetEntity: Phone::class, mappedBy: 'user', fetch: 'LAZY')]
    private Collection $phones;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $status = 0;



    /**
     * @param string $login
     * @param string $password
     * @param int $status
     */
    public function __construct(string $login, string $password, int $status = self::STATUS_DISABLED)
    {
        $this->login = $login;
        $this->changePassword($password);
        $this->status = $status;
        $this->phones = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function changeLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function changePassword(string $password): void
    {
        $this->password = md5($password);
    }

    public function isActiveUser(): bool
    {
        return $this->status === static::STATUS_ACTIVE;
    }

    public function isDisabledUser(): bool
    {
        return $this->status === static::STATUS_DISABLED;
    }

    public function isVIPUser(): bool
    {
        return $this->status === static::STATUS_VIP;
    }

    public function setStatusDisabled(): void
    {
        $this->status = static::STATUS_DISABLED;
    }

    public function setStatusActive(): void
    {
        $this->status = static::STATUS_ACTIVE;
    }

    public function setStatusVIP(): void
    {
        $this->status = static::STATUS_VIP;
    }


    /**
     * @return Collection
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    /**
     * @param Phone $phone
     */
    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
    }

}
