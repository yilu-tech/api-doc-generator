<?php


namespace YiluTech\ApiDocGenerator\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class Example
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 */
final class Operation extends Base
{
    /**
     * @var string
     * @Enum({"get", "post", "put", "patch", "delete", "options", "head"})
     */
    public $method;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array<string>
     */
    public $tags;

    /**
     * @var boolean
     */
    public $deprecated;

    /**
     * @var string
     */
    public $operationId;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Parameter>
     */
    public $parameters;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\RequestBody
     */
    public $requestBody;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Response>
     * default : The documentation of responses other than the ones declared for specific HTTP response codes.
     *      Use this field to cover undeclared responses. A Reference Object can link to a response that the OpenAPI Object's components/responses section defines.
     * HTTP Status Code: Any HTTP status code can be used as the property name, but only one property per code, to describe the expected response for that HTTP status code.
     *      A Reference Object can link to a response that is defined in the OpenAPI Object's components/responses section.
     * This field MUST be enclosed in quotation marks (for example, "200") for compatibility between JSON and YAML.
     * To define a range of response codes, this field MAY contain the uppercase wildcard character X.
     * For example, 2XX represents all response codes between [200-299]. Only the following range definitions are allowed: 1XX, 2XX, 3XX, 4XX, and 5XX.
     * If a response is defined using an explicit code, the explicit code definition takes precedence over the range definition for that code.
     * @Required
     */
    public $responses;

    /**
     * @var \YiluTech\ApiDocGenerator\Annotations\ExternalDocs
     */
    public $externalDocs;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Server>
     */
    public $servers;

    protected $valueKey = 'method';

    protected $excepts = ['method'];

    public static $responseBody;

    public function toArray()
    {
        if ($this->responses) {
            $this->resetResponseBody();
        }
        return parent::toArray();
    }

    protected function resetResponseBody()
    {
        if ($this->responses) {
            foreach ($this->responses as $status => $response) {
                if (isset(self::$responseBody[$status])) {
                    $response->rewriteBody(self::$responseBody[$status]);
                }
            }
        }
    }
}
