<?php

namespace App\Http\Requests\Backend\Headquarters\GameVendor;

use App\Http\Requests\BaseFormRequest;

/**
 * Class EditRequest
 * @package App\Http\Requests\Backend\Headquarters\GameVendor
 */
class EditRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize() :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        if ($this->isMethod('post')) {
            return [
                'id' => 'required|exists:games_vendors,id',
                'name' => 'required|unique:games_vendors,name,'.$this->input('id'),
                'sign' => ['required','regex:/\w+/','unique:games_vendors,sign,'.$this->input('id')],
                'whitelist_ips' => 'array',
                'whitelist_ips.*' => 'ip',
            ];
        }
    }

    /**
     * @return array
     */
    public function messages() :array
    {
        return [
            'name.required' => '请填写游戏厂商名称',
            'name.unique' => '游戏厂商名称已存在',
            'sign.required' => '请填写游戏厂商标记',
            'sign.regex' => '游戏厂商标记只能包含数字,字母,下划线',
            'sign.unique' => '游戏厂商标记已存在',
            'whitelist_ips.array' => 'ip白名单为数组格式',
            'whitelist_ips.*.ip' => 'ip格式不正确',
        ];
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            'whitelist_ips' => 'cast:array',
        ];
    }
}