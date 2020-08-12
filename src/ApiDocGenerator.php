<?php


namespace YiluTech\ApiDocGenerator;


class ApiDocGenerator
{
    public function toArray()
    {
        $config = $this->getConfig();

        $parser = new RouteParser();
        $config['paths'] = $parser->parse();

        if (!empty($tags = $parser->getTags())) {
            $config['tags'] = array_merge($config['tags'] ?? [], $tags);
        }

        if (!empty($schemas = $parser->getSchemas())) {
            $config['components']['schemas'] = array_merge($config['components']['schemas'] ?? [], $schemas);
        }

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