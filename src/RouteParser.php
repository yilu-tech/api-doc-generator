<?php


namespace YiluTech\ApiDocGenerator;


use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use YiluTech\ApiDocGenerator\Annotations as SWG;

class RouteParser
{
    protected $tags = [];

    protected $schemas = [];

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    protected $classAnnotations = [];

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
        $paths = array();
        foreach ($this->routes() as $route) {
            $route = $this->parseRoute($route);
            if (empty($route)) continue;

            $path = $route['path'];
            unset($route['path']);
            $paths["/$path"] = $route;
        }
        return $paths;
    }

    public function getTags()
    {
        $tags = array_map(function ($tag) {
            return $tag->toArray();
        }, $this->tags);
        return array_values($tags);
    }

    public function getSchemas()
    {
        return array_map(function ($schemas) {
            return $schemas->toArray();
        }, $this->schemas);
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @return array|null
     * @throws \Exception
     */
    protected function parseRoute($route)
    {
        $controller = $route->getActionName();

        if ($controller === 'Closure' || strpos($controller, '@') === false) {
            return null;
        }

        [$controllerAnnotations, $controllerMethodAnnotations, $formAnnotations, $formMethodAnnotations, $parameters] = $this->parseRuteAction($route->getActionName());

        $parameters = $this->mergeParameters($parameters, $formAnnotations, $formMethodAnnotations, $controllerMethodAnnotations);
        $location = $this->getLocation($route, $controllerMethodAnnotations, $parameters);

        $this->eachAnnotations($location, $controllerAnnotations);
        $this->eachAnnotations($location, $controllerMethodAnnotations);

        return $location->toArray();
    }

    protected function parseRuteAction($action)
    {
        [$class, $method] = explode('@', $action, 2);

        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->hasMethod($method)) {
            throw new \Exception("Undefined $action");
        }

        $classAnnotations = $this->parseClassAnnotations($reflectionClass);

        $reflectionMethod = $reflectionClass->getMethod($method);

        $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);

        if ($formRequestClass = $this->getRouteFormRequestClass($reflectionMethod)) {
            return array_merge([$classAnnotations, $methodAnnotations], $this->parseFormRequest($formRequestClass, $method));
        }

        return [$classAnnotations, $methodAnnotations, [], [], []];
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @return array
     */
    protected function parseClassAnnotations($reflectionClass)
    {
        $name = $reflectionClass->name;
        if (!isset($this->classAnnotations[$name])) {
            $this->classAnnotations[$name] = $this->annotationReader->getClassAnnotations($reflectionClass);
            $this->registerComponents($this->classAnnotations[$name]);
        }
        return $this->classAnnotations[$name];
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

        $classAnnotations = $this->parseClassAnnotations($reflectionClass);

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

    protected function mergeParameters(...$args)
    {
        $parameters = [];
        foreach ($args as $items) {
            foreach ($items as $item) {
                if ($item instanceof SWG\Parameter === false) continue;
                if (isset($parameters[$item->name])) {
                    $parameters[$item->name]->merge($item);
                } else {
                    $parameters[$item->name] = $item;
                }
            }
        }
        return $parameters;
    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function getQueryParameters($parameters)
    {
        return array_filter($parameters, function ($item) {
            return $item->in === 'query';
        });
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @param array $annotations
     * @param array $parameters
     * @return SWG\Location
     */
    protected function getLocation($route, $annotations, $parameters)
    {
        $location = Arr::first($annotations, function ($item) {
                return $item instanceof SWG\Location;
            }) ?? new SWG\Location();

        $location->path = $route->uri;

        foreach ($route->methods as $method) {
            $method = strtolower($method);
            $location->set($method, $this->getOperation($route, $annotations, $method, $parameters));

            $location->parameters = array_filter($parameters, function ($item) {
                return isset($item->in);
            });
        }

        preg_match_all('/(?:{(\w+)(\??)})/', $location->path, $matches);

        foreach ($matches[1] as $index => $value) {
            if (isset($parameters[$value])) {
                $parameter = $parameters[$value];
            } else {
                $parameter = new SWG\Parameter();
                $parameter->name = $value;
                $parameter->in = 'path';
                $parameter->schema = new SWG\Str();
            }
            if ($matches[2][$index] !== '?') {
                $parameter->required = true;
            }
            $location->parameters[$value] = $parameter;
        }

        if (!empty($location->parameters)) {
            $location->parameters = array_values($location->parameters);
        }

        return $location;
    }

    protected function getOperation($route, $annotations, $method, $parameters)
    {
        $operation = Arr::first($annotations, function ($item) use ($method) {
                return $item instanceof SWG\Operation && $item->method === $method;
            }) ?? new SWG\Operation();

        $operation->method = $method;

        if (in_array($method, ['post', 'put', 'patch'])) {
            $operation->set('requestBody', $this->getRequestBody($annotations, $parameters));
        }

        return $operation;
    }

    protected function getRequestBody($annotations, $parameters)
    {
        $requestBody = Arr::first($annotations, function ($item) {
                return $item instanceof SWG\RequestBody;
            }) ?? new SWG\RequestBody();

        $schema = new SWG\Obj();

        $parameters = array_filter($parameters, function ($item) {
            return empty($item->in);
        });

        foreach ($parameters as $parameter) {
            $schema->properties[$parameter->name] = $parameter->schema;
            if ($parameter->required) {
                $schema->required[] = $parameter->name;
            }
        }

        foreach ($annotations as $annotation) {
            if ($annotation instanceof SWG\MediaType) {
                $annotation->set('schema', $schema);
                $requestBody->content[$annotation->type] = $annotation;
            }
        }

        if (empty($requestBody->content)) {
            if ($requestBody->required) {
                throw new \Exception('Request body required.');
            }
            if ($schema->type) {
                $content = new SWG\ApplicationJson();
                $content->set('schema', $schema);
                $requestBody->content[$content->type] = $content;
            }
        }

        return $requestBody;
    }

    /**
     * @param array $annotations
     * @throws \Exception
     */
    protected function registerComponents($annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof SWG\Tag) {
                if (isset($this->tags[$annotation->name])) {
                    throw new \Exception(sprintf('Tag name "%s" exists.', $annotation->name));
                }
                $this->tags[$annotation->name] = $annotation;
            } elseif ($annotation instanceof SWG\Schema) {
                if (!$annotation->name) {
                    throw new \Exception('Undefined schema name.');
                }
                if (isset($this->schemas[$annotation->name])) {
                    throw new \Exception(sprintf('Schema name "%s" exists.', $annotation->name));
                }
                $this->schemas[$annotation->name] = $annotation;
            }
        }
    }

    /**
     * @param SWG\Location $location
     * @param array $annotations
     */
    protected function eachAnnotations($location, $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof SWG\Tags) {
                $this->eachOperations($location, function ($operation) use ($annotation) {
                    $operation->tags = $annotation->values;
                });
            } elseif ($annotation instanceof SWG\JsonResponse) {
                $response = $annotation->toResponse();
                $status = $annotation->status ?? 'default';
                $this->eachOperations($location, function (SWG\Operation $operation) use ($status, $response) {
                    if (isset($operation->responses[$status])) {
                        $operation->responses[$status]->set($response);
                    } else {
                        $operation->responses[$status] = $response;
                    }
                });
            }
        }
    }

    /**
     * @param SWG\Location $location
     * @param callable $callback
     */
    protected function eachOperations($location, $callback)
    {
        foreach (['get', 'post', 'put', 'delete', 'patch'] as $method) {
            if (isset($location->$method)) {
                $callback($location->$method);
            }
        }
    }

}