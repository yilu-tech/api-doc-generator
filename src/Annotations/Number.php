<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Number extends Schema
{
    /**
     * @var string
     * @Enum({"int32", "int64", "float", "double"})
     */
    public $format;

    /**
     * @var string
     * @property-read
     */
    public $type = 'number';

    /**
     * @var float
     */
    public $minimum;

    /**
     * @var bool
     */
    public $exclusiveMinimum;

    /**
     * @var float
     */
    public $maximum;

    /**
     * @var bool
     */
    public $exclusiveMaximum;

    /**
     * @var float
     */
    public $multipleOf;
}