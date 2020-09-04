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
    public function getSchema()
    {
        $schema = new Obj();

        $schema->properties = [
            'action' => [
                'type' => 'string',
                'enum' => ['prepare', 'query', 'export']
            ],
            'page' => ['type' => 'integer', 'minimum' => 1, 'exclusiveMinimum' => true],
            'size' => ['type' => 'integer', 'minimum' => 1, 'exclusiveMinimum' => true],
            'fields' => ['type' => 'array', 'items' => ['type' => 'string']],
            'params' => ['type' => 'array', 'items' => ['oneOf' => [['type' => 'string'], ['type' => 'number']]]],
        ];

        $schema->required = ['action'];

        return $schema;
    }

    public function toArray()
    {
        $mediaType = new MediaType();
        $mediaType->schema = $this->getSchema();

        $this->content = [
            'application/json' => $mediaType
        ];

        return parent::toArray();
    }
}