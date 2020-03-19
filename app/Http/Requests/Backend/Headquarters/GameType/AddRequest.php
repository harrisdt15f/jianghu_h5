<?php

namespace App\Http\Requests\Backend\Headquarters\GameType;

use App\Http\Requests\BaseFormRequest;
use App\Models\Game\GameType;
use App\Rules\Backend\Common\Sortable\CheckSortableModel;

/**
 * Class AddRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\GameType
 */
class AddRequest extends BaseFormRequest
{

    /**
     * 需要依赖模型中的字段备注信息
     * @var array<int,string>
     */
    protected $dependentModels = [GameType::class];

    /**
     * 自定义字段 【此字段在数据库中没有的字段字典】
     * @var array<string,string>
     */
    protected $extraDefinition = [
                                  'category_type' => '类别类型',
                                  'parent_id'     => '父级分类',
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
        $rules = [
                  'name'          => 'required|string|max:64|unique:game_types,name',
                  'sign'          => 'required|string|max:64|unique:game_types,sign',
                  'status'        => 'required|integer|in:0,1',
                  'parent_id'     => 'integer',
                  'category_type' => [
                                      'required',
                                      'integer',
                                      'in:1,2',
                                      new CheckSortableModel($this),
                                     ],
                 ];
        return $rules;
    }
}
