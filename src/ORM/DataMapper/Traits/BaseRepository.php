<?php


namespace App\ORM\DataMapper\Traits;

use App\ORM\DataMapper\Entity\User;
use Doctrine\ORM\EntityNotFoundException;

trait BaseRepository
{
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
}
