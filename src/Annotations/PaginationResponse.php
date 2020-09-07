<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"METHOD"})
 */
class PaginationResponse extends JsonResponse
{
    /**
     * @var mixed
     * @Required
     */
    public $content;

    /**
     * @var string
     */
    public $itemKey = 'data';

    public $overrideBody = true;

    protected $valueKey = 'content';

    protected $excepts = ['overrideBody', 'status', 'itemKey'];

    public function setValue($value)
    {
        if (is_array($value)) {
            $value = new Obj(['properties' => $value]);
        }
        $schema = new Schema([
            'oneOf' => [
                [
                    'type' => 'object',
                    'properties' => [
                        'display' => ['type' => 'string', 'enum' => ['default', 'simple']],
                        'headers' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/tableHeader']
                        ],
                        'fields' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/searchField']
                        ]
                    ]
                ],
                new Pagination(['value' => $value, 'itemKey' => $this->itemKey])
            ]
        ]);
        parent::setValue($schema);
    }
}