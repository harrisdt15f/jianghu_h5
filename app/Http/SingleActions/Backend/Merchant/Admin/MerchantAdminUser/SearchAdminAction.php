<?php

namespace App\Http\SingleActions\Backend\Merchant\Admin\MerchantAdminUser;

use App\Http\Controllers\BackendApi\Merchant\MerchantApiMainController;
use App\Models\Admin\MerchantAdminUser;
use App\ModelFilters\Admin\MerchantAdminUserFilter;
use Illuminate\Http\JsonResponse;

/**
 * Class for search admin action.
 */
class SearchAdminAction
{
    /**
     * @var object
     */
    protected $model;

    /**
     * @param MerchantAdminUser $merchantAdminUser MerchantAdminUser.
     */
    public function __construct(MerchantAdminUser $merchantAdminUser)
    {
        $this->model = $merchantAdminUser;
    }

    /**
     * @param MerchantApiMainController $contll     Controller.
     * @param array                     $inputDatas 接收的参数.
     * @return JsonResponse
     */
    public function execute(MerchantApiMainController $contll, array $inputDatas): JsonResponse
    {
        $inputDatas['platform'] = $contll->currentPlatformEloq->sign;
        $data = $this->model->filter($inputDatas, MerchantAdminUserFilter::class)->get()->toArray();
        return msgOut(true, $data);
    }
}