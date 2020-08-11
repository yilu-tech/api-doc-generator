<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @see https://swagger.io/specification/#example-object
 */
class Example extends Base
{
    /**
     * @var
     * @Required
     */
    public $value;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     * A URL that points to the literal example. This provides the capability to reference examples that cannot easily be included in JSON or YAML documents.
     * The value field and externalValue field are mutually exclusive.
     */
    public $externalValue;
}