<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "PROPERTY", "ANNOTATION"})
 */
final class Arr extends Schema
{
    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
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