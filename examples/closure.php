<?php

$request = [
    'login' => 'qwerty',
    'pass' => 'dsfasfawefeawf'
];

class User
{

    protected int $id;

    protected int $status = 1;

    protected DateTime $lastActivity;

    public function __construct(protected string $login, protected string $pass) {
        $this->id = rand();
        $this->lastActivity = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getLastActivity(): DateTime
    {
        return $this->lastActivity;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }
}


function app(array $request, ?callable $callback = null): void
{
    // validate
    // sql query
    $user = new User($request['login'], $request['pass']);

    if (!is_null($callback)) {
        $callback($user);
    }

    //
}
function app2(array $request, ?callable $validator = null): void
{
    if (!isset($request['login']) || !isset($request['pass'])) {
        throw new InvalidArgumentException();
    }
    if (!is_null($validator)) {
        $validator($request);
    }
    // sql query
    $user = new User($request['login'], $request['pass']);

    //
}

$logs = [];

$callback = function (User $u) {
    echo 'id: ' . $u->getId() . PHP_EOL;
    echo 'login: ' . $u->getLogin() . PHP_EOL;
    echo 'status: ' . $u->getStatus() . PHP_EOL;
    echo 'activity: ' . $u->getLastActivity()->format('Y-m-d') . PHP_EOL;
};

$callbackLog = function (User $u) use (&$logs) {
    $logs[] = [
        'id: ' => $u->getId(),
        'login: ' => $u->getLogin(),
        'status: ' => $u->getStatus(),
        'activity: ' => $u->getLastActivity(),
    ];
};

app($request, $callbackLog);



$v = function (array $r) {
    if (!isset($r['login']) || !isset($r['pass'])) {
        throw new InvalidArgumentException();
    }
    if (strlen($r['login']) < 4) {
        throw new InvalidArgumentException();
    }
    if (strlen($r['pass']) < 8) {
        throw new InvalidArgumentException();
    }
};


app2($request, $v);
















$a = 1;
$f = function (int $b) use($a)
{
   echo $a;
   echo $b;
   echo PHP_EOL;
};

$a = 2;
$f($a);

$a = 3;
$f($a);







