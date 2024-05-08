<?php


namespace App\ORM\DataMapper\Repositories;

use App\ORM\DataMapper\Entity\Phone;
use App\ORM\DataMapper\Entity\Shortener;
use App\ORM\DataMapper\Entity\User;
use App\ORM\DataMapper\Traits\BaseRepository;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeSaver;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;


class ShortenerRepository extends EntityRepository implements ICodeSaver
{
//    use BaseRepository;

    public function getById(int $id): object
    {
        $entity = $this->findOneBy(['id' => $id]);
        if (is_null($entity)) {
            throw new EntityNotFoundException('Entity with id: ' . $id . ' is not found');
        }
        return $entity;

    }

    /**
     * @param ?object $entity
     * @return $this
     */
    public function save(?object $entity = null): self
    {
        if (is_object($entity)) {
            $this->getEntityManager()->persist($entity);
        }
        $this->getEntityManager()->flush();
        return $this;
    }

    public function getCodeByUrl(string $url): ?string
    {
        $entity = $this->findOneBy(['url' => $url]);
        if (is_null($entity)) {
            return throw new DataNotFoundException();
        }
        return $entity->getShortCode();
    }

    public function getUrlByCode(string $code): ?string
    {
        $entity = $this->findOneBy(['short_code' => $code]);
        if (is_null($entity)) {
            return throw new DataNotFoundException();
        }
        return $entity->getUrl();
    }
    public function saveShortAndUrl(string $url, string $code): bool
    {
        $entity = new Shortener($url, $code);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return true;

    }
}
