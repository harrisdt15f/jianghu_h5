<?php

namespace App\Http\Controllers\SingleActions\Backend\Headquarters\GameType;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AddToAction
 * @package App\Http\Controllers\SingleActions\Backend\Headquarters\GameType
 */
class AddToAction extends BaseAction
{
    /**
     * @param Request $request Request.
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception Exception.
     */
    public function execute(Request $request) :JsonResponse
    {
        $inputDatas = $request->all();
        $this->model->name = $inputDatas['name'];
        $this->model->sign = $inputDatas['sign'];
        if ($this->model->save()) {
            return msgOut(true, [], '200', '添加成功');
        }
        return msgOut(false, [], '403', '添加失败');
    }
}
