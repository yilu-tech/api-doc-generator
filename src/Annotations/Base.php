<?php


namespace YiluTech\ApiDocGenerator\Annotations;


abstract class Base
{
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

    public function toArray()
    {
        $values = [];

        foreach ($this as $key => $value) {
            if (is_null($value)) continue;

            if (is_array($value)) {
                $value = array_map(function ($item) {
                    return $item instanceof self ? $item->toArray() : $item;
                }, $value);
            }

            if ($value instanceof self) {
                $value = $value->toArray();
            }

            $values[$key] = $value;
        }

        return $values;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}