<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;


use YiluTech\ApiDocGenerator\Annotations\Base;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Property extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Type\Type
     */
    public $type;

    /**
     * @var bool
     */
    public $readOnly;

    /**
     * @var bool
     */
    public $writeOnly;
}