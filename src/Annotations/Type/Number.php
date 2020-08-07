<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class Number extends Type
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
    public $mininum;

    /**
     * @var bool
     */
    public $exclusiveMinimum;

    /**
     * @var float
     */
    public $maxinum;

    /**
     * @var bool
     */
    public $exclusiveMaximum;

    /**
     * @var float
     */
    public $multipleOf;
}