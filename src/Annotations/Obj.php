<?php

namespace YiluTech\ApiDocGenerator\Annotations;


/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "PROPERTY", "ANNOTATION"})
 */
final class Obj extends Schema
{
    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
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