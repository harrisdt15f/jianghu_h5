<?php

namespace App\Http\SingleActions\Backend\Headquarters\Admin\BackendAdminUser;

use App\Http\SingleActions\MainAction;
use App\Models\Admin\BackendAdminUser;
use Illuminate\Http\JsonResponse;

/**
 * 创建后台管理员
 */
class CreateAction extends MainAction
{
    /**
     * Register api
     * @param array $inputDatas 接收的参数.
     * @return JsonResponse
     */
    public function execute(array $inputDatas): JsonResponse
    {
        $inputDatas['password'] = bcrypt($inputDatas['password']);
        $user                   = BackendAdminUser::create($inputDatas);
        $msgOut                 = msgOut(['name' => $user->name]);
        return $msgOut;
    }
}
