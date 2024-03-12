<?php

class SomeClass {

    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function sayHello(){
        echo 'Hello' . PHP_EOL;
    }

    public function sayHelloUser(): void {
        echo 'Hello, ' . $this->name . PHP_EOL;
    }

    public function __destruct(){
//        echo 'Objet is removed' . PHP_EOL;
    }

    public function __call(string $method, array $args) {
        $methods = [
            'say'=>'sayOne',
            'say2' =>'sayTwo'
        ];
        if (!isset($methods[$method])) {
            throw new Error('No such method found' . PHP_EOL);
        }
        $currentMethod = $methods[$method];
        return $this->$currentMethod($args);
    }

}

$o = new SomeClass('Peter');
$o->say();
//$o->sayHelloUser();
//unset($o);
//$o1 = new SomeClass('Alex');
//$o1->sayHelloUser();
//$o1->sayHelloUser();

