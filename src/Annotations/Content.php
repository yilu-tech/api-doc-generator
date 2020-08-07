<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
class Content
{
    /**
     * @var string
     * @Required
     * @Enum({"*\/*", "application/*", "application/json", "application/xml", "application/x-www-form-urlencoded", "text/plain", "image/*"})
     */
    public $type;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
     * @Required
     */
    public $schema;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Example
     */
    public $example;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Example》
     */
    public $examples;
}