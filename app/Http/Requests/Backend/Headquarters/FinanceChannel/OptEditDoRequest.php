<?php

namespace App\Http\Requests\Backend\Headquarters\FinanceChannel;

use App\Http\Requests\BaseFormRequest;

/**
 * Class OptEditDoRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\FinanceChannel
 */
class OptEditDoRequest extends BaseFormRequest
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
        $thisId = $this->get('id');
        return [
                'id'   => 'required|integer|exists:system_finance_channels,id',
                'name' => 'required|string|max:64|unique:system_finance_channels,name,' . $thisId,
                'desc' => 'string|string|max:64',
               ];
    }

    /**
     * @return mixed[]
     */
    public function messages(): array
    {
        return [
                'id.required'   => 'ID不存在',
                'id.exists'     => 'ID不存在',
                'name.required' => '请填写通道名称',
                'name.unique'   => '通道名称已存在',
                'desc.string'   => '备注格式不正确',
               ];
    }
}
