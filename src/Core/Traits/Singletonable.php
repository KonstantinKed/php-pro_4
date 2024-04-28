<?php


namespace App\Core\Traits;

trait Singletonable
{
    protected static ?self $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function closeMethod(): void
    {
        throw new \Exception('Object is singleton');
    }

    public function __clone()
    {
        $this->closeMethod();
    }

    public function __unserialise()
    {
        $this->closeMethod();
    }

    public function __wakeup()
    {
        $this->closeMethod();
    }


}
