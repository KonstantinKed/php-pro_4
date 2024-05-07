#!/usr/bin/env php
<?php

use App\ORM\DataMapper\Property;
use App\ORM\DataMapper\Entity\Phone;
use App\ORM\DataMapper\Entity\User;
use App\ORM\DataMapper\Repositories\PhoneRepository;
use App\ORM\DataMapper\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * @var UserRepository $userRepo
 * @var EntityRepository $phoneRepo
 * @var EntityManager $em
 */
$container = require_once __DIR__ . '/../src/bootstrap.php';

$em = $container->get(EntityManager::class);

//$user = new User('Alex', 'ssssss');
//$phone1 = new Phone($user, '111111');
//$phone2 = new Phone($user, '222222');
//$em->persist($user);
//$em->persist($phone1);
//$em->persist($phone2);


$em->flush();
//
//$userRepo = $em->getRepository(User::class);
//$phoneRepo = $em->getRepository(Phone::class);
//$user2 = new User('Сашко', 'dddd');
//$em->persist($user2);
//
//$user = $userRepo->findOneBy(['id' => 1]);
//
//$userRepo->getAllDataById(1);
//
//$user->setStatusVIP();




//$userRepo->save($user2);

//$em->flush();
//$phone = $phoneRepo->findOneBy(['id'=>1]);
//echo $phone->getPhone() . ' - ' . $phone->getUser()->getLogin();
//echo PHP_EOL;

exit;
