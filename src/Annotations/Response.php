<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION"})
 * @see https://swagger.io/specification/#response-object
 */
class Response extends Base
{
    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\MediaType>
     */
    public $content;

    /**
     * @var string
     * @Required
     */
    public $description;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Header>
     */
    public $headers;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Header>
     */
    public $links;
}