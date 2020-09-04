<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION", "METHOD"})
 * @see https://swagger.io/specification/#request-body-object
 */
class RequestBody extends Base
{
    /**
     * @var boolean
     */
    public $required;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\MediaType>
     */
    public $content;
}