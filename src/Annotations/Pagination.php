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
    public $item;

    /**
     * @var string
     */
    public $itemKey = 'data';

    public function getSchema()
    {
        $schema = new Obj();

        $items = new Arr();
        $items->items = $this->item;

        $pageCounter = new Integer();
        $pageCounter->minimum = 1;

        $total = new Integer();
        $total->minimum = 0;

        $schema->properties = [
            'current_page' => $pageCounter,
            'last_page' => $pageCounter,
            'per_page' => $pageCounter,
            'total' => $total,
            $this->itemKey => $items,
        ];

        $schema->required = ['current_page', 'last_page', 'per_page', 'total', $this->itemKey];
        return $schema;
    }

    public function toArray()
    {
        return $this->getSchema()->toArray();
    }
}