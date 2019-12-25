<?php

namespace App\Http\Controllers\BackendApi\Merchant\Finance;

use App\Http\Controllers\BackendApi\BackEndApiMainController;
use App\Http\Requests\Backend\Merchant\Finance\Offline\AddDoRequest;
use App\Http\Requests\Backend\Merchant\Finance\Offline\DelDoRequest;
use App\Http\Requests\Backend\Merchant\Finance\Offline\IndexRequest;
use App\Http\SingleActions\Backend\Merchant\Finance\Offline\AddDoAction;
use App\Http\SingleActions\Backend\Merchant\Finance\Offline\DelDoAction;
use App\Http\SingleActions\Backend\Merchant\Finance\Offline\IndexAction;
use App\Http\SingleActions\Backend\Merchant\Finance\Offline\TypesAction;
use Illuminate\Http\JsonResponse;

/**
 * Class OfflineFinanceController
 * @package App\Http\Controllers\BackendApi\Merchant\Finance
 */
class OfflineFinanceController extends BackEndApiMainController
{
    /**
     * 添加线下支付
     * @param AddDoAction  $action  Action.
     * @param AddDoRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function addDo(AddDoAction $action, AddDoRequest $request): JsonResponse
    {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($this, $inputDatas);
        return $outputDatas;
    }

    /**
     * 获取线下支付列表
     * @param IndexAction  $action  Action.
     * @param IndexRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function index(IndexAction $action, IndexRequest $request): JsonResponse
    {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($this, $inputDatas);
        return $outputDatas;
    }

    /**
     * 获取分类列表
     * @param TypesAction $action Action.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function types(TypesAction $action): JsonResponse
    {
        $outputDatas = $action->execute();
        return $outputDatas;
    }

    /**
     * 删除线下金流
     * @param DelDoAction  $action  Action.
     * @param DelDoRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function delDo(DelDoAction $action, DelDoRequest $request): JsonResponse
    {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($inputDatas);
        return $outputDatas;
    }
}