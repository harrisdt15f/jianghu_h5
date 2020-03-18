<?php

namespace App\Http\Requests\Backend\Headquarters\DeveloperUsage\Merchant\Menu;

use App\Http\Requests\BaseFormRequest;
use App\Models\DeveloperUsage\Menu\MerchantSystemMenu;

/**
 * Class for menu do add request.
 */
class DoAddRequest extends BaseFormRequest
{
  
    /**
     * @var array 需要依赖模型中的字段备注信息
     */
    protected $dependentModels = [MerchantSystemMenu::class];
    
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
                  'label'   => 'required|string|max:20|unique:merchant_system_menus|regex:/[\x{4e00}-\x{9fa5}]+/u', //标题(中文)
                  'en_name' => 'required|string|max:20|alpha_dash|unique:merchant_system_menus',//英文名
                  'display' => 'required|integer|in:0,1', //是否显示  0否 1是
                  'route'   => 'required|string|max:50|regex:/^(?!.*\/$)(?!.*?\/\/)[a-z\/-]+$/', //路由(小写+数字+“/”)
                  //图标(小写+数字+“-”)
                  'icon'    => 'string|max:20|regex:/^(?!\-)(?!.*\-$)(?!.*?\-\-)(?!\ )(?!.*\ $)(?!.*?\ \ )[a-z0-9 -]+$/',
                  'pid'     => 'required|integer',//父级ID
                  'level'   => 'required|integer',//层级
                 ];
        return $rules;
    }
}
