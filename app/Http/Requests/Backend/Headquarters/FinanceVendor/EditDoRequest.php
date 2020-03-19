<?php

namespace App\Http\Requests\Backend\Headquarters\FinanceVendor;

use App\Http\Requests\BaseFormRequest;
use App\Models\Finance\SystemFinanceVendor;

/**
 * Class EditDoRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\FinanceVendor
 */
class EditDoRequest extends BaseFormRequest
{

    /**
     * 需要依赖模型中的字段备注信息
     * @var array<int,string>
     */
    protected $dependentModels = [SystemFinanceVendor::class];

    /**
     * 自定义字段 【此字段在数据库中没有的字段字典】
     * @var array<string,string>
     */
    protected $extraDefinition = [
        'whitelist_ips.*' => '白名单',
    ];

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
        $myId = $this->get('ids');
        return [
                'id'              => 'required|integer|exists:system_finance_vendors,id',
                'name'            => 'required|string|max:64|unique:system_finance_vendors,name,' . $myId,
                'sign'            => 'required|alpha_dash|max:64|unique:system_finance_vendors,sign,' . $myId,
                'whitelist_ips'   => 'array',
                'whitelist_ips.*' => 'ip',
               ];
    }

    /**
     * @return mixed[]
     */
    public function filters(): array
    {
        return ['whitelist_ips' => 'cast:array'];
    }
}
