<?php

namespace App\Controllers;

use App\ORM\DataMapper\Entity\Phone;
use App\ORM\DataMapper\Entity\User;
use App\ORM\DataMapper\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UserController
{
    /**
     * @var UserRepository
     */
    protected EntityRepository $userRepo;
    protected EntityRepository $phoneRepo;

    public function __construct(
        protected EntityManager $em)
    {
        $this->userRepo = $this->em->getRepository(User::class);
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