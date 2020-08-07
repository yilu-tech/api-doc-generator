<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class Tag
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
}