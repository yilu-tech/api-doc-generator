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
     * @Enum({"string", "number", "integer", "array", "object"});
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
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $oneOf;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $allOf;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $onyOf;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
     */
    public $not;

    public function toArray()
    {
        $array = parent::toArray();
        unset($array['name']);
        return $array;
    }
}