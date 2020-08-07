<?php


namespace YiluTech\ApiDocGenerator\Annotations;


use Doctrine\Common\Annotations\Annotation\Enum;

/**
 * Class Parameter
 * @package Util
 * @Annotation
 * @Target("METHOD")
 */
final class Parameter extends Base
{
    /**
     * @var string
     * @Required
     */
    public $name;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\Schema
     */
    public $schema;

    /**
     * @var string
     * @Enum({"path", "query", "header", "cookie"})
     */
    public $in = 'query';

    /**
     * @var bool
     */
    public $required;

    /**
     * 支持 markdown
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $allowEmptyValue;

    /**
     * @var bool
     */
    public $deprecated;

    /**
     * @var string
     * @Enum({"simple", "label", "matrix", "from", "pipeDelimited", "spaceDelimited"})
     *      label： . 字首
     *      matrix： ; 字首
     *      from： ?或&前缀（取决于查询字符串中的参数位置）
     *      pipeDelimited： ?或&前缀（取决于查询字符串中的参数位置）–但是使用管道|而不是逗号,来连接数组值
     *      spaceDelimited： ?或&前缀（取决于查询字符串中的参数位置）–但使用空格而不是逗号,来连接数组值
     */
    public $style;

    /**
     * * 后缀
     * @var bool
     */
    public $explode;

    /**
     * + 字首
     * @var bool
     */
    public $allowReserved;
}
