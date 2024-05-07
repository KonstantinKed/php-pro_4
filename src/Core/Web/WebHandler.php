<?php


namespace App\Core\Web;

use App\Core\Web\Interfaces\IWebController;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function array_key_first;
use function current;

class WebHandler
{
    protected array $routing = [];

    /**
     * @var Request
     */
    protected RequestInterface $request;

    /**
     * @param IWebController[] $controllers
     */
    public function __construct(
        protected array $controllers,
        protected bool  $devMode = false
    )
    {
        $this->routingRegistration();
    }

    protected function routingRegistration(): void
    {
        foreach ($this->controllers as $controller) {
            $this->routing = array_merge($controller::ROUTS, $this->routing);
            $this->controllers[$controller::class] = $controller;
        }
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->request = $request;
        try {
            $routeController = $this->findRoute($request->getUri()->getPath());
            $objectController = $this->controllers[array_key_first($routeController)];
            $method = current($routeController);
            $response = call_user_func([$objectController, $method], $request);
        } catch (\Throwable $e) {
            $trace = $this->devMode ? $e->getMessage() . ' ::: ' . $e->getFile() . ': ' . $e->getLine() : '';
            $response = new Response(
                500,
                [],
                "Ooops!!! Something went wrong! <br>" . $trace
            );
        }
        return $response;
    }

    public function findRoute(string $path)
    {
        $routeController = $this->routing['/404'];

        if (isset($this->routing[$path])) {
            $routeController = $this->routing[$path];
        } else {
            $matches = [];
            foreach ($this->routing as $key => $value) {
                $pattern = '/^' . str_replace('/', '\/', $key) . '$/';
                if (preg_match($pattern, $path, $matches)) {
                    $routeController = $this->routing[$key];
                    break;
                }
            }
            $_GET['controller'] = $matches;
        }
        return $routeController;
    }
}