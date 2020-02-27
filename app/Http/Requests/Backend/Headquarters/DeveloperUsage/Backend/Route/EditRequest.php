<?php

namespace App\Http\Requests\Backend\Headquarters\DeveloperUsage\Backend\Route;

use App\Http\Requests\BaseFormRequest;
use App\Models\DeveloperUsage\Backend\SystemRoutesBackend;
use Illuminate\Validation\Rule;

/**
 * 路由-编辑
 */
class EditRequest extends BaseFormRequest
{
  
    /**
     * @var array 需要依赖模型中的字段备注信息
     */
    protected $dependentModels = [SystemRoutesBackend::class];
    
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
                  'id'            => 'required|exists:system_routes_backends',  //ID
                  'menu_group_id' => 'required|exists:backend_system_menus,id', //菜单ID
                  'title'         => 'required|string|max:32',                  //标题
                  'route_name'    => [
                                      'required',
                                      'string',
                                      'max:128',
                                      Rule::unique('system_routes_backends')->ignore($this->get('id')),
                                     ],                                           //路由名称
                  'controller'    => 'required|string|max:64', //控制器
                  'method'        => 'required|string|max:32', //方法
                 ];
        return $rules;
    }
}
