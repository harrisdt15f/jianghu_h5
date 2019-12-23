<?php

namespace App\Http\Requests\Backend\Merchant\User\UserGrade;

use App\Http\Requests\BaseFormRequest;

/**
 * 用户等级-删除
 */
class DeleteRequest extends BaseFormRequest
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
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:users_grades', //ID
        ];
    }

    /**
     * @return mixed[]
     */
    public function messages(): array
    {
        return [
            'id.exists' => '该等级配置不存在',
        ];
    }
}
