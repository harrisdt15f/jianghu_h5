<?php

namespace App\Http\Requests\Backend\Headquarters\Admin;

use App\Http\Requests\BaseFormRequest;

/**
 * Class for partner admin group create request.
 */
class MerchantDoAddRequest extends BaseFormRequest
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
            'name' => 'required|unique:merchant_admin_users', //名称
            'email' => 'required|email|unique:merchant_admin_users', //邮箱
            'password' => 'required|string', //密码
            'role' => 'required|string', //权限
        ];
    }

    /*public function messages()
{
return [
'lottery_sign.required' => 'lottery_sign is required!',
'trace_issues.required' => 'trace_issues is required!',
'balls.required' => 'balls is required!'
];
}*/
}
