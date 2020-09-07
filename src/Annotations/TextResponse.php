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

    protected $valueKey = 'content';

    public function setValue($value)
    {
        if ($this->content instanceof Str === false || $this->content instanceof Reference === false) {
            $value = new Str();
        }
        $this->content = [
            'text/plain' => new MediaType(['schema' => $value])
        ];
    }
}