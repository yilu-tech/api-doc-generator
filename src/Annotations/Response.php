<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"ANNOTATION", "METHOD"})
 * @see https://swagger.io/specification/#response-object
 */
class Response extends Base
{
    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\MediaType>
     */
    public $content;

    /**
     * @var integer
     */
    public $status;

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
     * @var array
     */
    public $links;

    /**
     * @var boolean
     */
    public $overrideBody;

    protected $valueKey = 'content';

    protected $excepts = ['overrideBody', 'status'];

    public function rewriteBody(array $contents)
    {
        foreach ($this->content as $type => $item) {
            if (empty($contents[$type]) || $this->overrideBody) continue;

            if ($ref = &$this->getBodyRoot($contents[$type])) {
                $ref = $item->schema;
                $item->schema = $contents[$type];
            }
        }
    }

    protected function &getBodyRoot(&$body)
    {
        $ref = null;
        foreach ($body as &$item) {
            if ($item === '$ref') {
                return $item;
            }
            if (is_array($item) && $ref = &$this->getBodyRoot($item)) {
                return $ref;
            }
        }
        return $ref;
    }
}