<?php

namespace App\Controllers;

use App\ORM\DataMapper\Entity\Shortener;

use App\ORM\DataMapper\Repositories\ShortenerRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ShortenerController
{
    /**
     * @var ShortenerRepository
     */
    protected EntityRepository $shortenerRepo;

    public function __construct(
        protected EntityManager $em)
    {
//        $this->userRepo = $this->em->getRepository(User::class);
        $this->shortenerRepo = $this->em->getRepository(Shortener::class);
    }
    public function getInfo(int $id): string
    {
//        return 'info for ' . $id;
        $user = $this->userRepo->getById($id);
        return $user->getLogin() . ' - ' . $user->getStatus();
    }

    public function getAll() {
        $users = $this->userRepo->findAll();
        $result = '';
        foreach ($users as $user) {
            $result .= $user->getLogin() . ' - ' . $user->getStatus() . '<br>';
        }
        return $result;
    }


    public function addPhone(int $id, string $phone): string {
        $user = $this->userRepo->getById($id);
        $p = new Phone($user, $phone);
        $this->userRepo->save($p);
//        return $user->getLogin() . ' - ' . $user->getPhones();
        return $user->getLogin() . $this->phoneRepo->getPhone();
    }



}