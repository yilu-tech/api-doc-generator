<?php


namespace YiluTech\ApiDocGenerator\Annotations;


use Doctrine\Common\Annotations\Annotation\Enum;

/**
 * Class Parameter
 * @package Util
 * @Annotation
 * @Target("METHOD")
 */
final class OperationId
{
    /**
     * @var string
     * @Required
     */
    public $value;
}
