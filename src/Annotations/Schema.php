<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Schema
 * @package Util
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Schema extends Base
{
    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Type\Type
     * @required
     */
    public $type;

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
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Type\Type>
     */
    public $oneOf;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Type\Type>
     */
    public $allOf;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Type\Type>
     */
    public $onyOf;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Type\Type
     */
    public $not;

    /**
     * @param Schema $other
     * @throws \Exception
     */
    public function merge($other)
    {
        if (get_class($other) !== get_class($this->type)) {
            throw new \Exception('Schema type error.');
        }

        $this->type->merge($other->type);
        $other->type = $this->type;

        parent::merge($other);
    }

    public function toArray()
    {
        return parent::toArray();
    }
}