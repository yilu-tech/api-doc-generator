<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;


/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Obj extends Type
{
    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Type\Property>
     */
    public $properties;

    /**
     * @var string
     * @property-read
     */
    public $type = 'object';

    /**
     * @var integer
     */
    public $minProperties;

    /**
     * @var integer
     */
    public $maxProperties;

    /**
     * @var array<string>
     */
    public $required;

    /**
     * @var mixed
     */
    public $additionalProperties;
}