<?php


namespace App\Core\Web;

use App\Core\Exceptions\ParameterNotFoundException;
use App\Core\Helpers\StringTypeCasting;
use App\Core\Web\Exceptions\RouteNotFoundException;
use App\Core\Web\Interfaces\IWebController;
use App\Core\Web\Middleware\ParamConverter\Exceptions\ParamConverterException;
use App\Core\Web\Middleware\ParamConverter\Interfaces\IParamConverter;
use App\Core\Web\VO\Params;
use App\Core\Web\VO\Route;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function in_array;

class WebHandlerPro
{
    protected array $routing = [];

    /**
     * @var Request
     */
    protected RequestInterface $request;

    /**
     * @param IWebController[] $controllers
     * @throws \ReflectionException
     */
    public function __construct(
        protected array           $controllers,
        protected IParamConverter $paramConverter,
        protected bool            $devMode = false
    )
    {
        $this->routingRegistration();
    }

    /**
     * @throws \ReflectionException
     */
    protected function routingRegistration(): void
    {
        foreach ($this->controllers as $controller) {
            $refController = new \ReflectionObject($controller);
            foreach ($refController->getMethods() as $method) {
                if (empty($method->getAttributes(Route::class))) {
                    continue;
                }
                /**
                 * @var \ReflectionAttribute $attribute
                 */

                $attribute = current($method->getAttributes(Route::class));
                $routeObject = $attribute->newInstance();

                $refRoute = new \ReflectionObject($routeObject);
                $pController = $refRoute->getProperty('controller');
                $pController->setValue($routeObject, $controller);

                $pMethod = $refRoute->getProperty('method');
                $pMethod->setValue($routeObject, $method->getName());

                $this->routing[$routeObject->getRoute()] = $routeObject;
            }
        }

    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->request = $request;
        try {
            $routeObject = $this->findRoute($request->getUri()->getPath(), $request);
            $response = call_user_func_array(
                [$routeObject->getController(), $routeObject->getMethod()],
                $routeObject->getParameters()
            );
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

    /**
     * @param string $path
     * @return Route
     * @throws \ReflectionException
     * @throws ParamConverterException
     */
    public function findRoute(string $path, RequestInterface $request): Route
    {
        try {
            if (!isset($this->routing[$path])) {
                throw new \TypeError();
            }
            $routeObject = $this->routing[$path];
        } catch (\Throwable) {
            $routeObject = $this->routing['/404'];
            $matches = [];
            foreach ($this->routing as $key => $value) {
                $pattern = '/^' . str_replace('/', '\/', $key) . '$/';
                if (preg_match($pattern, $path, $matches)) {
                    $routeObject = $value;
                    array_shift($matches);
                    break;
                }
            }

            if (!empty($matches)) {
                $this->mapData($routeObject, $matches);
            }
        }
        /**
         * @var Route $routeObject
         */
        if (!in_array($request->getMethod(), $routeObject->getHttpMethods())) {
            throw new RouteNotFoundException(
                'Method ' . $request->getMethod() . ' is not allowed for ' . $request->getUri()->getPath());
        }
        return $routeObject;
    }

    /**
     * @param Route $routeObject
     * @param array $matches
     * @return void
     * @throws ParamConverterException
     * @throws \ReflectionException
     */
    protected function mapData(Route $routeObject, array $matches): void
    {
        $refMethod = new \ReflectionMethod(
            $routeObject->getController(),
            $routeObject->getMethod()
        );
        $parametersForConvert = new Params([]);
        if (!empty($attributes = $refMethod->getAttributes(Params::class))) {
            $parametersForConvert = $attributes[0]->newInstance();
        }

        $methodArguments = $refMethod->getParameters();
        foreach ($matches as $i => $match) {
            $attrName = $methodArguments[$i]->getName();
            try {
                $parameterForConvert = $parametersForConvert->getParam($attrName);
                $dataForConvert = $parameterForConvert->getValue();
                $data = $this->paramConverter->convert($match, $dataForConvert);
            } catch (ParameterNotFoundException) {
                $data = StringTypeCasting::casting($match, $methodArguments[$i]->getType()->getName());
            }
            $routeObject->addParameter($data, $attrName);
        }
    }

}