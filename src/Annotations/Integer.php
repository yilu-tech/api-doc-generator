<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Integer extends Schema
{
    /**
     * @var string
     * @property-read
     */
    public $type = 'integer';

    /**
     * @var string
     * @Enum({"int32", "int64"})
     */
    public $format;

    /**
     * @var integer
     */
    public $minimum;

    /**
     * @var integer
     */
    public $maximum;

    /**
     * @var integer
     */
    public $multipleOf;

    /**
     * @var bool
     */
    public $exclusiveMinimum;

    /**
     * @var bool
     */
    public $exclusiveMaximum;

    protected $valueKey = 'format';
}