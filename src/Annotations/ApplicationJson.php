<?php

namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
final class ApplicationJson extends MediaType
{
    /**
     * @var string
     * @Required
     */
    public $type = 'application/json';
}