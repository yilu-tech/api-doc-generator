<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
final class JsonResponse
{
    /**
     * @var mixed
     * @Required
     */
    public $value;

    /**
     * @var integer
     */
    public $status = 200;

    /**
     * @var string
     * @Required
     */
    public $description;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Header>
     */
    public $headers;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Header>
     */
    public $links;

    public function toResponse()
    {
        $response = new Response();
        $response->headers = $this->headers;
        $response->description = $this->description;
        $response->links = $this->links;

        $mediaType = new MediaType();

        if ($this->value instanceof Reference) {
            $schema = $this->value;
        } else if (is_array($this->value)) {
            $schema = new Obj();
            $schema->properties = $this->value;
        } else {
            $schema = new Arr();
            $schema->items = $this->value;
        }
        $mediaType->schema = $schema;
        $response->content = [
            'application/json' => $mediaType
        ];
        return $response;
    }
}