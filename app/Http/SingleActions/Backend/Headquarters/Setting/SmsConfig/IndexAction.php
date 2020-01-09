<?php

namespace App\Http\SingleActions\Backend\Headquarters\Setting\SmsConfig;

use App\Http\Resources\Backend\Headquarters\Setting\SmsConfig\IndexResource;
use App\ModelFilters\System\SystemSmsConfigFilter;
use App\Models\Systems\SystemSmsConfig;
use Illuminate\Http\JsonResponse;

/**
 * 短信配置-列表
 */
class IndexAction
{

    /**
     * Comment
     * @var SystemSmsConfig
     */
    protected $model;

    /**
     * @param SystemSmsConfig $systemSmsConfig 短信配置Model.
     */
    public function __construct(SystemSmsConfig $systemSmsConfig)
    {
        $this->model = $systemSmsConfig;
    }

    /**
     * @param array $inputDatas 接收的参数.
     * @return JsonResponse
     */
    public function execute(array $inputDatas): JsonResponse
    {
        $data = $this->model
            ->filter($inputDatas, SystemSmsConfigFilter::class)
            ->with('admin:id,name')
            ->get();

        $msgOut = msgOut(true, IndexResource::collection($data));
        return $msgOut;
    }
}
