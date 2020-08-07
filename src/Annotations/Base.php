<?php


namespace YiluTech\ApiDocGenerator\Annotations;


abstract class Base
{
    /**
     * @param static $other
     */
    public function merge($other)
    {
        $properties = array_filter((array)$other, 'isset');

        foreach ($properties as $name => $value) {
            $this->{$name} = $value;
        }
    }

    public function isset($name)
    {
        return isset($name);
    }

    public function toArray()
    {
        return array_filter((array)$this, [$this, 'isset']);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}