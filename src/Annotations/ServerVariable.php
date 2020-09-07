<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class ServerVariable extends Base
{
    /**
     * @var string
     * @Required
     */
    public $default;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array<string>
     */
    public $enum;

    protected $valueKey = 'default';
}