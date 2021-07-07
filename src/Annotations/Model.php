<?php


namespace YiluTech\ApiDocGenerator\Annotations;

/**
 * Class Str
 * @package YiluTech\ApiDocGenerator\Annotations
 * @Annotation
 * @Target({"CLASS", "PROPERTY", "ANNOTATION"})
 */
final class Model extends Schema
{
    /**
     * @readonly
     * @var string
     */
    public $type = 'object';

    /**
     * @var string
     * @required
     */
    public $class;

    /**
     * @var array<\YiluTech\ApiDocGenerator\Annotations\Schema>
     */
    public $properties;

    /**
     * @var array<string>
     */
    public $exceptKeys;

    protected $valueKey = 'class';

    protected $excepts = ['class', 'name'];

    public function __construct($values = null)
    {
        parent::__construct($values);

        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $this->class();

        if (empty($this->properties[$model->getKeyName()])) {
            $this->properties[$model->getKeyName()] = new Integer();
        }

        $propKeys  = $model->getFillable();
        $propTypes = $model->getCasts();

        if ($model->incrementing) {
            array_unshift($propKeys, $model->getKeyName());
            $propTypes[$model->getKeyName()] = 'int';
        }

        if ($model->timestamps) {
            array_push($propKeys, 'created_at', 'updated_at');
            $propTypes['created_at'] = 'datetime';
            $propTypes['updated_at'] = 'datetime';
        }

        $propKeys = array_diff($propKeys, $model->getHidden());

        if ($this->exceptKeys) {
            $propKeys = array_diff($propKeys, $this->exceptKeys);
        }

        foreach ($propKeys as $key) {
            if (isset($this->properties[$key])) continue;
            $this->properties[$key] = $this->newPropertity($propTypes[$key] ?? null);
        }
    }

    protected function newPropertity($cast)
    {
        switch ($cast) {
            case 'int':
            case 'integer':
            case 'timestamp':
                return new Integer();
            case 'real':
            case 'float':
            case 'decimal':
                return new Number(['format' => 'float']);
            case 'double':
                return new Number(['format' => 'double']);
            case 'bool':
            case 'boolean':
                return new Boolean();
            case 'object':
            case 'array':
            case 'json':
                return new Obj();
            case 'collection':
                return new Arr();
            case 'date':
                return new Str(['format' => 'date']);
            case 'datetime':
            case 'custom_datetime':
                return new Str(['format' => 'date-time']);
            case 'string':
            default:
                return new Str();
        }
    }
}
