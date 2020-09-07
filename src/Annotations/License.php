<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class License extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    protected $valueKey = 'name';
}