<?php


namespace YiluTech\ApiDocGenerator;


use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Foundation\Http\FormRequest;

class RouteParser
{
    protected $controllerAnnotations = [];

    protected $actionAnnotations = [];

    protected $formAnnotations = [];

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @return \Illuminate\Routing\RouteCollection
     */
    public function routes()
    {
        return app()->router->getRoutes();
    }

    public function parse()
    {
        foreach ($this->routes() as $route) {
            $this->parseRoute($route);
        }
        return [];
    }

    /**
     * @param \Illuminate\Routing\Route $route
     */
    protected function parseRoute($route)
    {
        $controller = $route->getActionName();

        if ($controller === 'Closure') {
            return;
        }

        [$controllerAnnotations, $controllerMethodAnnotations, $formAnnotations, $formMethodAnnotations, $parameters] = $this->parseRuteAction($route->getActionName());

        if ($parameters != null) {
            dd($formMethodAnnotations);
        }
    }

    protected function parseRuteAction($action)
    {
        [$class, $method] = explode('@', $action, 2);

        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->hasMethod($method)) {
            throw new \Exception("Undefined $action");
        }

        $classAnnotations = $this->annotationReader->getClassAnnotations($reflectionClass);

        $reflectionMethod = $reflectionClass->getMethod($method);

        $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);

        if ($formRequestClass = $this->getRouteFormRequestClass($reflectionMethod)) {
            return array_merge([$classAnnotations, $methodAnnotations], $this->parseFormRequest($formRequestClass, $method));
        }

        return [$classAnnotations, $methodAnnotations, [], [], []];
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return FormRequest|string|null
     * @throws \ReflectionException
     */
    protected function getRouteFormRequestClass($reflectionMethod)
    {
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $type = (string)$reflectionParameter->getType();
            if (is_subclass_of($type, FormRequest::class)) {
                return $type;
            }
        }
        return null;
    }

    /**
     * @param string $class
     * @param string $method
     * @return array
     */
    protected function parseFormRequest($class, $method)
    {
        $method .= 'Rules';
        $reflectionClass = new \ReflectionClass($class);

        $classAnnotations = $this->annotationReader->getClassAnnotations($reflectionClass);

        if (!$reflectionClass->hasMethod($method)) {
            return [$classAnnotations, [], []];
        }

        $reflectionMethod = $reflectionClass->getMethod($method);
        $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);

        $rules = app()->call("$class@$method");
        $parser = new ParameterParser($rules);

        return [$classAnnotations, $methodAnnotations, $parser->parse()];
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @return array
     */
    protected function getRouteParameters($route)
    {
        $controller = $route->getActionName();

        if ($controller === 'Closure') {
            return [];
        }

        [$class, $action] = explode('@', $controller, 2);


        $fromRequestClass = $this->getRouteFormRequestClass($class, $action);


        $reflectionClass = new \ReflectionClass($fromRequestClass);

        $action .= 'Rules';

        if (!$reflectionClass->hasMethod($action)) {
            return [];
        }

        $rules = app()->call("$fromRequestClass@$action");

        $parser = new ParameterParser($rules);

        return $parser->parse();
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @param string $method
     * @return Annotations\Location
     */
    protected function makeLocation($route, $method)
    {
        $location = new Annotations\Location();

        $location->path = $route->uri();

        $location->method = strtolower($method);

        if ($location->method == 'get' || $location->method == 'delete') {
            $parameters = $this->getRouteParameters();

        }


        return $location;
    }

    protected function makeRequestBody($route)
    {
        $body = new Annotations\RequestBody();

        $body->content[] = $route->uri();

        return $body;
    }

    protected function makeRequestContent()
    {
        $content = new Annotations\Content();
        $content->type = 'application/json';

    }
}