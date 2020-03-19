<?php

namespace App\Http\Requests\Backend\Headquarters\Admin\BackendAdminUser;

use App\Http\Requests\BaseFormRequest;
use App\Models\Admin\BackendAdminUser;

/**
 * 管理员自己修改密码
 */
class SelfUpdatePasswordRequest extends BaseFormRequest
{
    
    /**
     * @var array 需要依赖模型中的字段备注信息
     */
    protected $dependentModels = [BackendAdminUser::class];

    /**
     * @var array 自定义字段 【此字段在数据库中没有的字段字典】
     */
    protected $extraDefinition = ['old_password' => '旧密码'];

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
        $rules = [
                  'old_password' => [
                                     'required',
                                     'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/',//(必须存在大小写字母+数字的8-16位)
                                    ], //旧密码
                  'password'     => [
                                     'required',
                                     'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/',//(必须存在大小写字母+数字的8-16位)
                                    ], //新密码
                 ];
        return $rules;
    }
}
