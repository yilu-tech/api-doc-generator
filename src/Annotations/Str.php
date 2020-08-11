<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Str extends Schema
{
    /**
     * @var string
     * @Enum({"date", "date-time", "password", "byte", "binary", "email", "uuid", "uri", "hostname", "ipv4", "ipv6"})
     */
    public $format;

    /**
     * @var string
     * @property-read
     */
    public $type = 'string';

    /**
     * @var string
     */
    public $pattern;

    /**
     * @var integer
     */
    public $minLength;

    /**
     * @var integer
     */
    public $maxLength;
}