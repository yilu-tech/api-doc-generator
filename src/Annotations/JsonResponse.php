<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target("METHOD")
 */
class JsonResponse extends Response
{
    /**
     * @var mixed
     * @Required
     */
    public $content;

    public function getSchema()
    {
        if ($this->content instanceof Reference) {
            return $this->content;
        }
        if (is_array($this->content)) {
            $schema = new Obj();
            $schema->properties = $this->content;
        } else {
            $schema = new Arr();
            $schema->items = $this->content;
        }
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