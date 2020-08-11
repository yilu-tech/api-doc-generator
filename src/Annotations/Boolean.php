<?php


namespace YiluTech\ApiDocGenerator\Annotations;

use YiluTech\ApiDocGenerator\Annotations\Schema;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Boolean extends Schema
{
    /**
     * @var string
     * @property-read
     */
    public $type = 'boolean';
}