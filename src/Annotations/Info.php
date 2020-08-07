<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS"})
 */
class Info
{
    /**
     * @var
     * @Required
     */
    public $title;

    /**
     * @var string
     * @Required
     */
    public $version;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $termsOfService;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\ExternalDocs
     */
    public $externalDocs;
}