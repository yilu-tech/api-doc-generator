<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 */
class Server extends Base
{
    /**
     * @var string
     * @Required
     */
    public $url;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\ServerVariable>
     */
    public $variables;
}