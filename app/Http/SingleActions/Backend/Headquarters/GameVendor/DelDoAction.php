<?php

namespace App\Http\SingleActions\Backend\Headquarters\GameVendor;

use App\Models\Game\Game;
use Illuminate\Http\JsonResponse;

/**
 * Class DelDoAction
 * @package App\Http\SingleActions\Backend\Headquarters\GameVendor
 */
class DelDoAction extends BaseAction
{
    /**
     * @param array $inputDatas InputDatas.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function execute(array $inputDatas) :JsonResponse
    {
        if (!Game::where('vendor_id', $inputDatas['id'])->get()->isEmpty()) {
            throw new \Exception('300300');
        }
        if ($this->model->where('id', $inputDatas['id'])->delete()) {
            return msgOut(true, [], '200');
        } else {
            throw new \Exception('300301');
        }
    }
}
