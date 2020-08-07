<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class Location
{
    /**
     * @var string
     * @Required
     */
    public $path;

    /**
     * @var string
     * @Enum({"get", "post", "patch", "put", "delete"})
     */
    public $method;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Parameter>
     */
    public $parameters;

    /**
     * @var boolean
     */
    public $deprecated;

    /**
     * @var string
     */
    public $operationId;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\RequestBody
     */
    public $requestBody;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\ExternalDocs
     */
    public $externalDocs;
}