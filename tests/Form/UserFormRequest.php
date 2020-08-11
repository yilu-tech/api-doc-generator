<?php


namespace Tests\Form;


use Illuminate\Foundation\Http\FormRequest;
use YiluTech\ApiDocGenerator\Annotations as SWG;

class UserFormRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function createRules()
    {
        return [
            'name' => "required|string|min:2|max:32",
            'password' => 'required|password',
            'sex' => 'required|in:0,1,2',
            'tags' => 'array|max:5',
            'tags.*' => 'in:member,student,teacher'
        ];
    }

    /**
     * @return string[]
     */
    public function updateRules()
    {
        return [
            'id' => 'required|integer',
            'name' => "string|min:2|max:32",
            'password' => 'password',
            'sex' => 'in:1,2',
            'tags' => 'array|max:5',
            'tags.*' => 'in:member,student,teacher'
        ];
    }
}