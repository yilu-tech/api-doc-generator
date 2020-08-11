<?php


namespace YiluTech\ApiDocGenerator\Annotations;


/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Mixed extends Schema
{
    public function __toString()
    {
        return '{}';
    }
}