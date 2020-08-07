<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class RequestBody
{
    /**
     * @var boolean
     */
    public $required;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Content>
     */
    public $content;
}