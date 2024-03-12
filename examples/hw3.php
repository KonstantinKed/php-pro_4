<?php

class Email {
    protected string $email;
    public function __construct($email) {
        $this->email = $email;
    }
    public function setEmailAddress($email): void
    {
        $this->email = $email;
    }
    public function getEmailAddress(): string
    {
        return $this->email;
    }
}
class Client {
    protected $name;
    protected $email;
    public function __construct($name, Email $email) {
        $this->setName($name);
        $this->setEmail($email);
    }
    public function __clone() {
        $this->email = clone $this->email;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setName($name): void {
        $this->name = $name;
    }
    public function getEmail(): Email {
        return $this->email;
    }
    public function setEmail(Email $email): void {
        $this->email = $email;
    }
}

$email1 = new Email('Kostya@gmail.com');
$client1 = new Client("Kostya", $email1);

$client2 = clone $client1;
$client2->setName("Anna");
$client2->getEmail()->setEmailAddress("Anna@gmail.com");

echo $client1->getName() . ' email address is: ' . $client1->getEmail()->getEmailAddress() . PHP_EOL;
echo $client2->getName() . ' email address is: ' . $client2->getEmail()->getEmailAddress() . PHP_EOL;




// __toString, __debugInfo(), __set_state()
class Car {
    protected $brand;
    protected $model;
    protected $year;
    protected $owner;

    public function __construct($brand, $model, $year, $owner) {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->owner = $owner;
    }
    public function __toString() {
        return 'This car is: ' . $this->brand . ' ' . $this->model . ' (' . $this->year . ') owned by ' . $this->owner . PHP_EOL;
    }
    public function __debugInfo() {
        return [
            'name' => $this->brand,
            'model' => $this->model,
            'year' => $this->year
        ];
    }

    public static function __set_state($properties) {
        return new self($properties['name'], $properties['model'], $properties['year'], $properties['owner']);
    }

    public function saveObject($filename, $exportedObj): int|false
    {
        return file_put_contents($filename, $exportedObj);
    }
}
$car = new Car("Tesla", "Model Y", 2024, 'Kostya');
echo $car;
var_dump($car);

$exportedObj = var_export($car, true);
$car->saveObject(__DIR__. '/hw3_car.php', $exportedObj);