<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION"})
 */
class Pagination extends Base
{
    /**
     * @var mixed
     * @Required
     */
    public $value;

    /**
     * @var string
     */
    public $itemKey = 'data';

    public function setValue($value)
    {
        $value = new Obj([
            'properties' => [
                $this->itemKey => new Arr(['items' => $value])
            ],
            'required' => [$this->itemKey]
        ]);

        $this->value = new Schema([
            'allOf' => [new Reference('#/components/schemas/pagination'), $value]
        ]);
    }

    public function toArray()
    {
        return $this->value->toArray();
    }
}