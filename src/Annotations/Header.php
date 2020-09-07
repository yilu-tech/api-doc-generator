<?php


namespace YiluTech\ApiDocGenerator\Annotations;


use Doctrine\Common\Annotations\Annotation\Enum;

/**
 * Class Parameter
 * @package Util
 * @Annotation
 * @Target("METHOD", "CLASS")
 * @see https://swagger.io/specification/#header-object
 */
final class Header extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
     */
    public $schema;

    /**
     * 支持 markdown
     * @var string
     */
    public $description;

    protected $valueKey = 'name';
}
