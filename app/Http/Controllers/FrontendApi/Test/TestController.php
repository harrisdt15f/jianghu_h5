<?php

namespace App\Http\Controllers\FrontendApi\Test;

use App\Http\Controllers\FrontendApi\FrontendApiMainController;
use Illuminate\Http\Request;

/**
 * Class TestController
 * @package App\Http\Controllers\FrontendApi\Test
 */
class TestController extends FrontendApiMainController
{

    /**
     * 测试帐变接口
     * @param  Request $request Request.
     * @return mixed
     */
    public function accountChange(Request $request)
    {
        $inputDatas = $request->all();
        $user       = $this->frontendUser;
        if (!$user) {
            return;
        }
        $account = $user->account;
        if (!$account) {
            return;
        }
        $inputDatas['params'] = json_decode($inputDatas['params'], true);
        if (!$inputDatas['params']) {
            $inputDatas['params'] = [];
        }
        $data   = $account->operateAccount($inputDatas, $inputDatas['type'], $inputDatas['params']);
        $msgOut = msgOut($data);
        return $msgOut;
    }
}
