<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"METHOD"})
 * @see https://swagger.io/specification/#request-body-object
 */
class SearchRequest extends RequestBody
{
    public function setValue($value)
    {
        $schema = new Obj([
            'properties' => [
                'action' => [
                    'type' => 'string',
                    'enum' => ['prepare', 'query', 'export']
                ],
                'page' => ['type' => 'integer', 'minimum' => 1, 'exclusiveMinimum' => true],
                'size' => ['type' => 'integer', 'minimum' => 1, 'exclusiveMinimum' => true],
                'fields' => ['type' => 'array', 'items' => ['type' => 'string']],
                'params' => ['type' => 'array', 'items' => ['oneOf' => [['type' => 'string'], ['type' => 'number']]]],
            ],
            'required' => ['action']
        ]);
        $this->content = [
            'application/json' => new MediaType(['schema' => $schema])
        ];
    }
}