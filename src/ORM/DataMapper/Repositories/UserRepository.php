<?php


namespace App\ORM\DataMapper\Repositories;

use App\ORM\DataMapper\Entity\Phone;
use App\ORM\DataMapper\Entity\User;
use App\ORM\DataMapper\Traits\BaseRepository;
use Doctrine\ORM\EntityRepository;

/**
 * @method User getById($id): User
 */
class UserRepository extends EntityRepository
{
    use BaseRepository;

    public function findActive(bool $sortAsc = true): array
    {
        return $this->findBy(['status' => User::STATUS_ACTIVE], ['id' => $sortAsc ? 'ASC' : 'DESC']);
    }

    public function getAllDataById(int $id): User
    {
        $user = $this->findOneBy(['id' => $id]);
        if (is_null($user)) {
            throw new \InvalidArgumentException();
        }
        return $user;
    }

    public function getAllDataById2(int $id): User
    {
        $qb = $this->createQueryBuilder('u')
            ->leftJoin(Phone::class, 'p', 'WITH', 'p.user = u.id')
            ->where('u.id = :id')->setParameter('id', $id)
            ->orWhere('u.status = :status')->setParameter('status', User::STATUS_ACTIVE)
            ->setMaxResults(1);

        $query = $qb->getQuery();
        $r = $query->getResult();
        return $query->getResult()[0];
    }

    public function getBanList()
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.status = :status')
            ->setParameter('status', User::STATUS_DISABLED)
            ->orderBy('u.login', 'ASC');

        $query = $qb->getQuery();
        $sql = $query->getSQL();

        return $query->getResult();
    }


}
