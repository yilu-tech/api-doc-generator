<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Schema
 * @package Util
 * @Annotation
 * @Target({"CLASS", "METHOD", "ANNOTATION"})
 * @see https://swagger.io/specification/#schema-object
 */
class Schema extends Base
{
    /**
     * @var string
     * @Enum({"string", "number", "integer", "array", "object", "boolean"});
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * 支持 markdown
     * @var string
     */
    public $description;

    /**
     * @var mixed
     */
    public $default;

    /**
     * @var array
     */
    public $enum;

    /**
     * @var bool
     */
    public $nullable;

    /**
     * @var array
     */
    public $oneOf;

    /**
     * @var array
     */
    public $allOf;

    /**
     * @var array
     */
    public $anyOf;

    /**
     * @var mixed
     */
    public $not;

    protected $valueKey = 'type';

    protected $excepts = ['name'];
}