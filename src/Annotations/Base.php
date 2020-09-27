<?php


namespace YiluTech\ApiDocGenerator\Annotations;


abstract class Base
{
    /**
     * @var string
     */
    public $ref;

    protected $valueKey = 'value';

    protected $excepts = [];

    public function __construct($values = null)
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if ($key === 'value' || $key === $this->valueKey) {
                    $this->setValue($value);
                } else {
                    $this->{$key} = $value;
                }
            }
        } else if (isset($values)) {
            $this->setValue($values);
        }
    }

    public function setValue($value)
    {
        $this->{$this->valueKey} = $value;
    }

    /**
     * @param static $other
     * @throws \Exception
     */
    public function merge($other)
    {
        if ($other instanceof static === false) {
            throw new \Exception(sprintf('Class type "%s" error, should be "%s"', get_class($other), static::class));
        }

        foreach ($other as $key => $value) {
            if (isset($value)) {
                $this->set($key, $value);
            }
        }
    }

    public function set($key, $value)
    {
        if ($this->$key instanceof self) {
            $this->$key->merge($value);
        } else {
            $this->$key = $value;
        }
    }

    protected function formatToArray($value)
    {
        if ($value instanceof self) {
            $value = $value->toArray();
        } elseif (is_object($value)) {
            $value = array_filter((array)$value);
        }
        if (is_array($value)) {
            $value = array_map([$this, 'formatToArray'], $value);
        }
        return $value;
    }

    public function toArray()
    {
        if ($this->ref) {
            return ['$ref' => $this->ref];
        }

        $values = [];
        $excepts = array_merge($this->excepts, ['excepts', 'ref', 'valueKey']);

        foreach ($this as $key => $value) {
            if (is_null($value) || in_array($key, $excepts)) continue;
            $values[$key] = $this->formatToArray($value);
        }

        return $values;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}