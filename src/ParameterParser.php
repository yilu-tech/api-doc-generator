<?php


namespace YiluTech\ApiDocGenerator;


use Illuminate\Validation\ValidationRuleParser;
use YiluTech\ApiDocGenerator\Annotations\Type;

class ParameterParser
{
    protected $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function parse()
    {
        $rules = $this->parseRules($this->rules);
        return $this->arrayToParameters($rules);
    }

    protected function arrayToParameters($attributes)
    {
        $parameters = [];

        foreach ($attributes as $name => $value) {
            $parameter = $this->toParameter($name, $value);
            $parameters[] = $parameter;
        }

        return $parameters;
    }

    protected function parseRules($rules)
    {
        $result = [];
        foreach ($rules as $key => $rule) {
            $rule = $this->explodeExplicitRule($rule);

            $items = [];

            foreach ($rule as $item) {
                if (!empty($item)) {
                    $item = ValidationRuleParser::parse($item);
                    $items[$item[0]] = $item[1];
                }
            }

            $this->setRuleForAttribute($result, $key, $items);
        }
        return $result;
    }

    protected function setRuleForAttribute(&$rules, $attribute, $rule)
    {
        $attributes = explode('.', $attribute);

        while (count($attributes) > 1) {
            $key = array_shift($attributes);

            if (!isset($rules[$key]['properties'])) {
                $rules[$key]['properties'] = [];
            }

            $rules = &$rules[$key]['properties'];
        }

        $rules[array_shift($attributes)]['rules'] = $rule;
    }

    protected function getAttributeType($name, $value)
    {
        if (isset($value['properties'])) {
            return isset($value['properties']['*']) ? 'array' : 'object';
        }
        if (isset($value['rules']['Array'])) {
            throw new \Exception("Undefined array \"$name\" items type.");
        }
        if (isset($value['rules']['Integer'])) {
            return 'integer';
        }
        if (isset($value['rules']['Numeric'])) {
            return 'number';
        }
        if (isset($value['rules']['Boolean'])) {
            return 'boolean';
        }
        return 'string';
    }

    protected function toParameter($name, $value)
    {
        $parameter = new Annotations\Parameter();

        $parameter->name = $name;
        $parameter->schema = $this->makeSchema($name, $value);

        $rules = $value['rules'];

        if (isset($rules['Required'])) {
            $parameter->required = true;
        } else if (isset($rules['nullable'])) {
            $parameter->allowEmptyValue = true;
        }

        return $parameter;
    }

    protected function makeSchema($name, $value)
    {
        $type = $this->getAttributeType($name, $value);
        switch ($type) {
            case 'integer':
                return $this->makeNumberSchema($name, $value, true);
            case 'boolean':
                return $this->makeBooleanSchema($name, $value);
            case 'array':
                return $this->makeArraySchema($name, $value);
            case 'object':
                return $this->makeObjectSchema($name, $value);
            case 'string':
                return $this->makeStringSchema($name, $value);
            default:
                return $this->makeMixedSchema($name, $value);
        }
    }

    protected function makeNumberSchema($name, $value, $integer = false)
    {
        $schema = $schema = new Annotations\Schema();
        $schema->type = $integer ? new Type\Integer() : new Type\Number();

        $rules = $value['rules'];
        if (isset($rules['Min'])) {
            $schema->type->mininum = $rules['Min'][0];
            $schema->type->exclusiveMinimum = true;
        }
        if (isset($rules['Max'])) {
            $schema->type->maxinum = $rules['Max'][0];
            $schema->type->exclusiveMaximum = true;
        }
        if (isset($rules['In'])) {
            $schema->enum = $rules['In'];
        }
        return $schema;
    }

    protected function makeStringSchema($name, $value)
    {
        $schema = new Annotations\Schema();
        $schema->type = new Type\Str();

        foreach ($value['rules'] as $key => $value) {
            switch ($key) {
                case 'In':
                    $schema->enum = $value;
                    break;
                case 'Min':
                    $schema->type->minLength = $value[0];
                    break;
                case 'Max':
                    $schema->type->maxLength = $value[0];
                    break;
                case 'Uri':
                case 'Date':
                case 'Ipv4':
                case 'Ipv6':
                case 'Email':
                case 'Password':
                    $schema->type->format = strtolower($key);
                    break;
                default:
                    break;
            }
        }
        return $schema;
    }

    protected function makeArraySchema($name, $value)
    {
        $schema = $schema = new Annotations\Schema();
        $schema->type = new Type\Arr();

        $rules = $value['rules'];
        if (isset($rules['Min'])) {
            $schema->type->minItems = $rules['Min'][0];
        }
        if (isset($rules['Max'])) {
            $schema->type->maxItems = $rules['Max'][0];
        }

        $schema->type->items = $this->makeSchema($name . '.*', $value['properties']['*']);
        return $schema;
    }

    protected function makeObjectSchema($name, $value)
    {
        $schema = $schema = new Annotations\Schema();
        $schema->type = new Type\Obj();

        $rules = $value['rules'];
        if (isset($rules['Min'])) {
            $schema->type->minProperties = $rules['Min'][0];
        }
        if (isset($rules['Max'])) {
            $schema->type->maxProperties = $rules['Max'][0];
        }
        foreach ($value['properties'] as $key => $property) {
            $schema->type->properties[] = $this->makeSchema("$name.$key", $property);

            if (isset($property['rules']['Required'])) {
                $schema->type->required[] = $key;
            }
        }
        return $schema;
    }

    protected function makeBooleanSchema($name, $value)
    {
        $schema = $schema = new Annotations\Schema();
        $schema->type = new Type\Boolean();
        return $schema;
    }

    protected function makeMixedSchema($name, $value)
    {
        $schema = $schema = new Annotations\Schema();
        $schema->type = new Type\Mixed();
        return $schema;
    }

    /**
     * Explode the explicit rule into an array if necessary.
     *
     * @param mixed $rule
     * @return array
     */
    protected function explodeExplicitRule($rule)
    {
        if (is_string($rule)) {
            return explode('|', $rule);
        } elseif (is_object($rule)) {
            return [];
        }
        return array_map([$this, 'prepareRule'], $rule);
    }

    /**
     * Prepare the given rule for the Validator.
     *
     * @param mixed $rule
     * @return mixed
     */
    protected function prepareRule($rule)
    {
        if ($rule instanceof \Closure) {
            return null;
        }

        if (!is_object($rule)) {
            return $rule;
        }

        return (string)$rule;
    }
}