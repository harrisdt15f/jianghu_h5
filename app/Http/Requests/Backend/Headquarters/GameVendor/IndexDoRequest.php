<?php

namespace App\Http\Requests\Backend\Headquarters\GameVendor;

use App\Http\Requests\BaseFormRequest;

/**
 * Class IndexDoRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\GameVendor
 */
class IndexDoRequest extends BaseFormRequest
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
    public function rules():array
    {
        return [
            'status' => 'integer|in:0,1',
            'name' => 'string|max:64',
        ];
    }

    /**
     * @return array
     */
    public function messages() :array
    {
        return [
            'status.in' => '所选状态不存在',
            'name.string' => '厂商名称不符合规则',
        ];
    }
}
