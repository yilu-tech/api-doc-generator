<?php


namespace YiluTech\ApiDocGenerator;


use YiluTech\ApiDocGenerator\Annotations\Operation;

class ApiDocGenerator
{
    protected static $handlers = [];

    public static function registerHandler($annotation, $handler)
    {
        static::$handlers[$annotation] = $handler;
    }

    protected static $booted = false;

    public function __construct()
    {
        $this->boot();
    }

    public function boot()
    {
        if (!self::$booted) {
            $config = $this->getConfig();
            Operation::$responseBody = $config['responseBody'] ?? null;

            self::$booted = true;
        }
    }

    public function toArray()
    {
        $config = $this->getConfig();

        $parser = new RouteParser($config);
        $config['paths'] = $parser->parse();

        if (!empty($tags = $parser->getTags())) {
            $config['tags'] = array_merge($config['tags'] ?? [], $tags);
        }

        if (!empty($schemas = $parser->getSchemas())) {
            $config['components']['schemas'] = array_merge($config['components']['schemas'] ?? [], $schemas);
        }

        unset($config['exceptPath'], $config['responseBody']);

        return $config;
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function toYaml()
    {
        return yaml_emit($this->toArray());
    }

    protected function getConfig()
    {
        return app()->config['swagger'] ?? [];
    }
}