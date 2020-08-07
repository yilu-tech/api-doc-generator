<?php


namespace Tests\Form;


use Illuminate\Foundation\Http\FormRequest;
use YiluTech\ApiDocGenerator\Annotations\Parameter;
use YiluTech\ApiDocGenerator\Annotations\Schema;
use YiluTech\ApiDocGenerator\Annotations\Type;

class UserFormRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    /**
     * @Parameter("name", schema=@Schema(@Type\Str(type="String")))
     * @return string[]
     */
    public function createRules()
    {
        return [
            'name' => 'required',
        ];
    }

}