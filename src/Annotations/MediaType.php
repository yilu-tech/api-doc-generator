<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class MediaType extends Base
{
    /**
     * @var string
     * @Required
     */
    public $type;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
     */
    public $schema;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Example
     */
    public $example;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Example>
     */
    public $examples;

    public $encoding;

    protected $excepts = ['type'];
}