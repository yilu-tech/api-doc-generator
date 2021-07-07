<?php


namespace YiluTech\ApiDocGenerator;


use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use YiluTech\ApiDocGenerator\Annotations as SWG;

class RouteParser
{
    protected $tags = [];

    protected $schemas = [];

    protected $config = [];

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    protected $classAnnotations = [];

    protected $pathPatterns;

    protected $responseBody;

    public function __construct($config)
    {
        $this->config = $config;

        $this->annotationReader = new AnnotationReader();

        $this->pathPatterns = $config['exceptPath'] ?? null;
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
        $this->mockAuthLogin();

        $paths = array();
        foreach ($this->routes() as $route) {
            if (!$this->validateRoute($route)) continue;

            $route = $this->parseRoute($route);

            $path = '/' . $route['path'];
            unset($route['path']);

            if (isset($paths[$path])) {
                $route = array_merge($paths[$path], $route);
            }
            $paths[$path] = $route;
        }
        return $paths;
    }

    protected function mockAuthLogin()
    {
        if (isset($this->config['authMocker'])) {
            $mocker = $this->config['authMocker'];
            Auth::login(is_string($mocker) ? app($mocker) : call_user_func($mocker));
        }
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
     * @return array
     * @throws \Exception
     */
    protected function parseRoute($route)
    {
        [$controllerAnnotations, $controllerMethodAnnotations, $formAnnotations, $formMethodAnnotations, $body] = $this->parseRuteAction($route->getActionName());

        $parameters = $this->mergeParameters($formAnnotations, $formMethodAnnotations, $controllerMethodAnnotations);
        $location   = $this->getLocation($route, $controllerMethodAnnotations, $parameters, $body);

        $this->eachAnnotations($location, $controllerAnnotations);
        $this->eachAnnotations($location, $controllerMethodAnnotations);

        return $location->toArray();
    }

    /**
     * @param \Illuminate\Routing\Route $route
     * @return boolean
     */
    protected function validateRoute($route)
    {
        $controller = $route->getActionName();

        if ($controller === 'Closure' || strpos($controller, '@') === false) {
            return false;
        }

        if ($this->pathPatterns) {
            $methods    = implode(',', $route->methods);
            $controller = '/' . $route->uri . '::' . $methods . '::' . $controller;

            foreach ($this->pathPatterns as $pattern) {
                if (preg_match($pattern, $controller)) {
                    return false;
                }
            }
        }

        return true;
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
            $type = $reflectionParameter->getType();
            if ($type instanceof \ReflectionNamedType &&
                is_subclass_of($type = $type->getName(), FormRequest::class)) {
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
        $reflectionClass = new \ReflectionClass($class);

        $classAnnotations = $this->parseClassAnnotations($reflectionClass);

        $methodAnnotations = [];
        $rules             = [];

        if ($reflectionClass->hasMethod($ruleMethod = $method . 'Rules')
            || $reflectionClass->hasMethod($ruleMethod = 'get' . ucfirst($method) . 'Rules')) {
            $reflectionMethod  = $reflectionClass->getMethod($ruleMethod);
            $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);

            $rules = app()->call("$class@$ruleMethod");
        } elseif ($reflectionClass->hasMethod('getSceneRules')) {
            $rules = app()->call("$class@getSceneRules", ['scene' => $method]);
        }

        if (!empty($rules)) {
            $parser = new ParameterParser($rules);
            $rules  = $parser->parse();
        }

        return [$classAnnotations, $methodAnnotations, $rules];
    }

    protected function mergeParameters(...$args)
    {
        $parameters = [];
        foreach ($args as $items) {
            foreach ($items as $item) {
                if ($item instanceof SWG\Parameter === false) continue;
                if (isset($parameters[$item->name])) {
                    $item = $parameters[$item->name]->merge($item);
                }
                $parameters[$item->name] = $item;
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
     * @param array                     $annotations
     * @param array                     $parameters
     * @param array                     $body
     * @return SWG\Location
     */
    protected function getLocation($route, $annotations, $parameters, $body)
    {
        $location = Arr::first($annotations, function ($item) {
                return $item instanceof SWG\Location;
            }) ?? new SWG\Location();

        $location->path = $route->uri;

        foreach ($route->methods as $method) {
            $method = strtolower($method);
            if (in_array($method, ['get', 'post', 'put', 'delete', 'patch'])) {
                $location->set($method, $this->getOperation($route, $annotations, $method, $parameters, $body));
            }
        }

        preg_match_all('/(?:{(\w+)(\??)})/', $location->path, $matches);

        foreach ($matches[1] as $index => $value) {
            if (isset($parameters[$value]) && $parameters[$value]->in === 'path') {
                $parameter = $parameters[$value];
            } else {
                $parameter         = new SWG\Parameter();
                $parameter->name   = $value;
                $parameter->schema = new SWG\Str();
                $parameter->in     = 'path';
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

    protected function getOperation($route, $annotations, $method, $parameters, $body)
    {
        $operation = Arr::first($annotations, function ($item) use ($method) {
                return $item instanceof SWG\Operation && $item->method === $method;
            }) ?? new SWG\Operation();

        $operation->method = $method;

        if (in_array($method, ['post', 'put', 'patch'])) {
            $operation->set('requestBody', $this->getRequestBody($annotations, $body));
        } else {
            foreach ($body as $parameter) {
                $parameter->in                           = 'query';
                $operation->parameters[$parameter->name] = $parameter;
            }
        }

        foreach ($parameters as $parameter) {
            if (empty($parameter->in)) {
                $parameter->in = 'query';
            }

            if ($parameter->in === 'path') continue;

            if (isset($operation->parameters[$parameter->name])) {
                $parameter = $operation->parameters[$parameter->name]->merge($parameter);
            }
            $operation->parameters[$parameter->name] = $parameter;
        }

        if (!empty($operation->parameters)) {
            $operation->parameters = array_values($operation->parameters);
        }
        return $operation;
    }

    protected function getRequestBody($annotations, $parameters)
    {
        $requestBody = Arr::first($annotations, function ($item) {
                return $item instanceof SWG\RequestBody;
            }) ?? new SWG\RequestBody();

        $schema = new SWG\Obj();

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
//                if (isset($this->tags[$annotation->name])) {
//                    throw new \Exception(sprintf('Tag name "%s" exists.', $annotation->name));
//                }
                $this->tags[$annotation->name] = $annotation;
            } elseif ($annotation instanceof SWG\Schema) {
                if (!$annotation->name) {
                    throw new \Exception('Undefined schema name.');
                }
//                if (isset($this->schemas[$annotation->name])) {
//                    throw new \Exception(sprintf('Schema name "%s" exists.', $annotation->name));
//                }
                $this->schemas[$annotation->name] = $annotation;
            }
        }
    }

    /**
     * @param SWG\Location $location
     * @param array        $annotations
     */
    protected function eachAnnotations($location, $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof SWG\Tag) {
                $this->eachOperations($location, function ($operation) use ($annotation) {
                    $operation->tags[] = $annotation->name;
                });
            } elseif ($annotation instanceof SWG\Tags) {
                $this->eachOperations($location, function ($operation) use ($annotation) {
                    $operation->tags = array_merge($annotation->value, $operation->tags ?? []);
                });
            } elseif ($annotation instanceof SWG\Response) {
                $status = $annotation->status ?? 'default';
                $this->eachOperations($location, function (SWG\Operation $operation) use ($status, $annotation) {
                    if (isset($operation->responses[$status])) {
                        $operation->responses[$status]->set($annotation);
                    } else {
                        $operation->responses[$status] = $annotation;
                    }
                });
            }
        }
    }

    /**
     * @param SWG\Location $location
     * @param callable     $callback
     */
    protected function eachOperations($location, $callback)
    {
        foreach (['get', 'post', 'put', 'delete', 'patch'] as $method) {
            if (isset($location->$method)) {
                call_user_func($callback, $location->$method);
            }
        }
    }
}
