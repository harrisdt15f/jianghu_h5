<?php

namespace App\Http\SingleActions\Backend\Merchant\Notice\Carousel;

use App\Http\Controllers\BackendApi\BackEndApiMainController;
use Illuminate\Http\JsonResponse;

/**
 * Class EditAction
 * @package App\Http\SingleActions\Backend\Merchant\Notice\Carousel
 */
class EditAction extends BaseAction
{
    /**
     * @param BackEndApiMainController $contll     Contll.
     * @param array                    $inputDatas InputDatas.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function execute(BackEndApiMainController $contll, array $inputDatas): JsonResponse
    {
        $inputDatas['last_editor_id'] = $contll->currentAdmin->id;
        $model                        = $this->model->find($inputDatas['id']);
        $model->fill($inputDatas);
        $result = $model->save();
        if ($result) {
            $msgOut = msgOut(true);
            return $msgOut;
        }
        throw new \Exception('201901');
    }
}
