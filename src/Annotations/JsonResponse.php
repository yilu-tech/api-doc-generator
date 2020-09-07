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

    public function setValue($value)
    {
        if (is_array($value)) {
            $value = new Obj(['properties' => $value]);
        }
        $this->content = [
            'application/json' => new MediaType(['schema' => $value])
        ];
    }
}