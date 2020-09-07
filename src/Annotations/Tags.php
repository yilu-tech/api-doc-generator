<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class Tags
{
    /**
     * @var array<string>
     * @Required
     */
    public $value;
}