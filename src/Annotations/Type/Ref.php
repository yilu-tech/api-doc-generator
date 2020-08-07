<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Ref extends Type
{

    /**
     * @var string
     * @Required
     */
    public $target;

    public function __toString()
    {
        return $this->target;
    }
}