<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class Components
{
    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $schemas;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $parameters;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $securitySchemes;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $requestBodies;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $responses;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $headers;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $examples;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $links;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $callbacks;
}