<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Integer extends Number
{
    /**
     * @var string
     * @Enum({"int32", "int64"})
     */
    public $format;

    /**
     * @var string
     * @property-read
     */
    public $type = 'integer';

    /**
     * @var integer
     */
    public $mininum;

    /**
     * @var integer
     */
    public $maxinum;

    /**
     * @var integer
     */
    public $multipleOf;
}