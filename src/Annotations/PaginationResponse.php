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

    protected $excepts = ['overrideBody', 'status', 'itemKey'];

    public function getSchema()
    {
        $pagination = new Pagination();

        if ($this->content instanceof Reference) {
            $pagination->item = $this->content;
        } else {
            $pagination->item = ['type' => 'object', 'properties' => $this->content];
        }
        $pagination->itemKey = $this->itemKey;

        return [
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
                $pagination->getSchema()
            ]
        ];
    }
}