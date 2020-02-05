<?php

namespace App\Http\Controllers\BackendApi\Merchant\Finance;

use App\Http\Requests\Backend\Merchant\Finance\RechargeOrder\GetFinanceTypesRequest;
use App\Http\Requests\Backend\Merchant\Finance\RechargeOrder\HandleSuccessRequest;
use App\Http\Requests\Backend\Merchant\Finance\RechargeOrder\IndexRequest;
use App\Http\SingleActions\Backend\Merchant\Finance\RechargeOrder\GetFinanceTypesAction;
use App\Http\SingleActions\Backend\Merchant\Finance\RechargeOrder\HandleSuccessAction;
use App\Http\SingleActions\Backend\Merchant\Finance\RechargeOrder\IndexAction;
use Illuminate\Http\JsonResponse;

/**
 * Class RechargeOrderController
 * @package App\Http\Controllers\BackendApi\Merchant\Finance
 */
class RechargeOrderController
{
    /**
     * 入款订单列表.
     *
     * @param IndexAction  $action  Action.
     * @param IndexRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function index(IndexAction $action, IndexRequest $request): JsonResponse
    {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($inputDatas);
        return $outputDatas;
    }

    /**
     * 获取支付方式.
     *
     * @param GetFinanceTypesAction  $action  Action.
     * @param GetFinanceTypesRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function getFinanceTypes(
        GetFinanceTypesAction $action,
        GetFinanceTypesRequest $request
    ): JsonResponse {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($inputDatas);
        return $outputDatas;
    }

    /**
     * 手动入款.
     *
     * @param HandleSuccessAction  $action  Action.
     * @param HandleSuccessRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function handleSuccess(
        HandleSuccessAction $action,
        HandleSuccessRequest $request
    ): JsonResponse {
        $inputDatas  = $request->validated();
        $outputDatas = $action->execute($inputDatas);
        return $outputDatas;
    }
}