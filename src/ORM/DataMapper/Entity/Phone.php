<?php


namespace App\ORM\DataMapper\Entity;


use App\ORM\DataMapper\Traits\JsonSerializableTrait;
use App\ORM\DataMapper\VO\PrivateProperties;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity]
#[ORM\Table(name: 'phones')]
#[PrivateProperties([])]
//class Phone implements JsonSerializable
class Phone
{
//    use JsonSerializableTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'LAZY', inversedBy: 'phones')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\Column(length: 45)]
    private string $phone;

    /**
     * @param User $user
     * @param string $phone
     */
    public function __construct(User $user, string $phone)
    {
        $this->user = $user;
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

}
