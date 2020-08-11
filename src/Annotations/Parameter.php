<?php


namespace YiluTech\ApiDocGenerator\Annotations;


use Doctrine\Common\Annotations\Annotation\Enum;

/**
 * Class Parameter
 * @package Util
 * @Annotation
 * @Target({"METHOD", "ANNOTATION"})
 * @see https://swagger.io/specification/#parameter-object
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
    public $in;

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
     * Describes how the parameter value will be serialized depending on the type of the parameter value.
     * Default values (based on value of in): for query - form; for path - simple; for header - simple; for cookie - form.
     */
    public $style;

    /**
     * * 后缀
     * @var bool
     * When this is true, parameter values of type array or object generate separate parameters for each value of the array or key-value pair of the map.
     * For other types of parameters this property has no effect. When style is form, the default value is true. For all other styles, the default value is false.
     */
    public $explode;

    /**
     * + 字首
     * @var bool
     * Determines whether the parameter value SHOULD allow reserved characters, as defined by RFC3986 :/?#[]@!$&'()*+,;= to be included without percent-encoding.
     * This property only applies to parameters with an in value of query. The default value is false.
     */
    public $allowReserved;

    public function key()
    {
        return $this->in . ':' . $this->name;
    }
}
