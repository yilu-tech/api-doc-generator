<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target("ANNOTATION")
 */
class ExternalDocs extends Base
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $url;

    protected $valueKey = 'description';
}