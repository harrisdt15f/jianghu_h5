<?php

namespace App\Http\Requests\Backend\Headquarters\FinanceVendor;

use App\Http\Requests\BaseFormRequest;
use App\Models\Finance\SystemFinanceVendor;

/**
 * Class IndexDoRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\FinanceVendor
 */
class IndexDoRequest extends BaseFormRequest
{

    /**
     * 需要依赖模型中的字段备注信息
     * @var array<int,string>
     */
    protected $dependentModels = [SystemFinanceVendor::class];

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
}
