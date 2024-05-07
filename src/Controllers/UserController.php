<?php

namespace App\Controllers;

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
    public function __construct(
        protected EntityManager $em)
    {
        $this->userRepo = $this->em->getRepository(User::class);
    }
    public function userInfo(int $id): string
    {
//        return 'info for ' . $id;
        $user = $this->userRepo->getById($id);
        return $user->getLogin() . '-' . $user->getStatus();
    }
}