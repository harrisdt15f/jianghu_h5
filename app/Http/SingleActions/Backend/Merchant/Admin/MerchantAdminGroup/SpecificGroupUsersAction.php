<?php

namespace App\Http\SingleActions\Backend\Merchant\Admin\MerchantAdminGroup;

use App\Models\Admin\MerchantAdminAccessGroup;
use Illuminate\Http\JsonResponse;

/**
 * Class for specific group users action.
 */
class SpecificGroupUsersAction
{
    /**
     * @var MerchantAdminAccessGroup
     */
    protected $model;

    /**
     * @param MerchantAdminAccessGroup $merchantAdminAccessGroup MerchantAdminAccessGroup.
     */
    public function __construct(MerchantAdminAccessGroup $merchantAdminAccessGroup)
    {
        $this->model = $merchantAdminAccessGroup;
    }

    /**
     * @param array $inputDatas 传递的参数.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function execute(array $inputDatas): JsonResponse
    {
        $accessGroupEloq = $this->model::find($inputDatas['id']);
        if ($accessGroupEloq !== null) {
            $data = $accessGroupEloq->adminUsers->toArray();
            return msgOut(true, $data);
        } else {
            throw new \Exception('300100');
        }
    }
}