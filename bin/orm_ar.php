<?php


use App\ORM\ActiveRecord\DatabaseAR;
use App\ORM\ActiveRecord\Models\Phone;
use App\ORM\ActiveRecord\Models\User;
use Illuminate\Database\Capsule\Manager;

$container = require_once __DIR__ . '/../src/bootstrap.php';
$container->get(Manager::class);  // main connection trough config/services
//
//
//$dbManager = new Manager();
//$dbManager->addConnection([
//  "driver" => 'mysql',
//  "host" => 'db_mysql',
//  "database" => 'base',
//  "username" => 'doctor',
//  "password" => 'pass4doctor',
//  "charset" => 'utf8',
//  "collation" => 'utf8_unicode_ci',
//  "prefix" => '',
//]);
//
//$dbManager->bootEloquent();
//new DatabaseAR('base', 'doctor', 'pass4doctor', 'db_mysql');


//$user = new User('Ігор');
//$user->save();
//
//$phone = new Phone('7777', $user);
//
//$phone->save();
//$a = 1;
//$user->name = 'Андрій';
//$user->save();
//$user->delete();
//$user->setName('sdfsdfs');

//$user = new User('Артур','user7@');
$users = User::all();

$user = User::find(1);
//$phone1 = $user->phones[0];
//$phone1->setPhone('123');
//$phone->delete();
//$phone2 = new Phone('666', $user);

//$user->email = 'u5@';
//$user->delete();
//$user->save();
//$phone1->save();
//$phone2->save();


/**
 * @var User $user
 */
echo $user->name . ' - ' . count($user->phones) . ': ';// . $user->phones->pluck('phone')->implode(', ') . PHP_EOL;

foreach ($user->phones as $phone) {
    echo $phone->phone . ', ';
}
echo PHP_EOL;


exit;
