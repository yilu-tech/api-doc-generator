<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Arr extends Type
{
    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Type\Type
     * @Required
     */
    public $items;

    /**
     * @var string
     * @property-read
     */
    public $type = 'array';

    /**
     * @var integer
     */
    public $minItems;

    /**
     * @var integer
     */
    public $maxItems;

    /**
     * @var bool
     */
    public $uniqueItems;
}