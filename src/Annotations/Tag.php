<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class Tag extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\ExternalDocs
     */
    public $externalDocs;

    protected $valueKey = 'name';
}