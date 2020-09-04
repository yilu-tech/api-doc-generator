<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target("METHOD")
 */
class TextResponse extends Response
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

        if ($this->content instanceof Str === false) {
            return new Str();
        }
        return $this->content;
    }

    public function toArray()
    {
        $mediaType = new MediaType();
        $mediaType->schema = $this->getSchema();

        $this->content = [
            'text/plain' => $mediaType
        ];
        return parent::toArray();
    }
}