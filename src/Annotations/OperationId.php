<?php


namespace YiluTech\ApiDocGenerator\Annotations;


/**
 * Class Parameter
 * @package Util
 * @Annotation
 * @Target("METHOD")
 */
final class OperationId extends Base
{
    /**
     * @var string
     * @Required
     */
    public $value;
}
