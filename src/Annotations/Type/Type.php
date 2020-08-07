<?php


namespace YiluTech\ApiDocGenerator\Annotations\Type;

use YiluTech\ApiDocGenerator\Annotations\Base;

/**
 * Class Nil
 * @package YiluTech\ApiDocGenerator\Annotations\Type
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class Type extends Base
{
    /**
     * @var string
     * @Required
     */
    public $type;
}