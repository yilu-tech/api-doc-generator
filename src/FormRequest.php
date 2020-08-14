<?php


namespace YiluTech\ApiDocGenerator;

use Illuminate\Foundation\Http\FormRequest as Base;
use Illuminate\Support\Facades\Route;

class FormRequest extends Base
{
    public $rules = [];

    public function rules()
    {
        $method = $this->getRuleName();
        if ($method && method_exists($this, $method)) {
            return $this->$method();
        }
        return [];
    }

    public function getRules($key = null)
    {
        if (empty($key)) {
            return $this->rules;
        }

        if (is_array($key)) {
            return array_intersect_key($this->rules, array_flip($key));
        }

        return $this->rules[$key] ?? null;
    }

    protected function getRuleName()
    {
        $action = Route::getCurrentRoute()->getActionName();
        if (strpos($action, '@') === false) {
            return null;
        }
        [$class, $action] = explode('@', $action, 2);
        return $action . 'Rules';
    }
}