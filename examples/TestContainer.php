<?php


use App\Commands\TestCommand;
use App\Core\CLI\CommandHandler;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContainerNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}

class TestContainer implements ContainerInterface
{

    protected array $services = [];

    /**
     * @param array $services
     */
    public function __construct(array $services)
    {
        foreach ($services as $id => $callback) {
            $this->addService($id, $callback);
        }
    }

    protected function addService(string $id, Closure $def): void
    {
        $this->services[$id] = $def;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new ContainerNotFoundException();
        }
        return $this->services[$id]($this);
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}

$container = new TestContainer(require_once __DIR__ . '/../config/testContainer.php');

try {
    /**
     * @var CommandHandler $commandHandler
     */
    $commandHandler = $container->get(CommandHandler::class);
    $commandHandler->handle([]);
} catch (\Throwable) {
}