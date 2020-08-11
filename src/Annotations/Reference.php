<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class Reference extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    public function toArray()
    {
        return ['$ref' => $this->name];
    }
}