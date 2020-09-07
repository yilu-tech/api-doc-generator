<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
final class Location extends Base
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var boolean
     */
    public $description;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $get;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $post;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $put;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $delete;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $options;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $head;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $patch;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Operation
     */
    public $trace;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Parameter>
     */
    public $parameters;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Server>
     */
    public $servers;

    protected $valueKey = 'path';

    public function toArray()
    {
        return array_filter(parent::toArray());
    }
}