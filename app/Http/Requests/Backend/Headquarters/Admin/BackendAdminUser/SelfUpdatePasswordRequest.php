<?php

namespace App\Http\Requests\Backend\Headquarters\Admin\BackendAdminUser;

use App\Http\Requests\BaseFormRequest;

/**
 * 管理员自己修改密码
 */
class SelfUpdatePasswordRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|string', //旧密码
            'password' => ['required', 'string', 'between:6,16', 'regex:/^(?=.*[a-zA-Z]+)(?=.*[0-9]+)[a-zA-Z0-9]+$/'], //新密码
        ];
    }

    /**
     * 返回信息
     * @return array
     */
    public function messages()
    {
        return [
            'password.between' => '管理员密码必须是6---16位之间',
            'password.regex' => '管理员密码必须是字母+数字组合，不能有特殊字符',
        ];
    }
}
