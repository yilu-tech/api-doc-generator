<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Boolean extends Type
{
    /**
     * @var string
     * @property-read
     */
    public $type = 'boolean';
}