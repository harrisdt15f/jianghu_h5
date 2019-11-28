<?php

namespace App\Http\Controllers\BackendApi\Headquarters;

use App\Http\Requests\Backend\Headquarters\Game\AddRequest;
use App\Http\Requests\Backend\Headquarters\Game\DelRequest;
use App\Http\Requests\Backend\Headquarters\Game\EditRequest;
use App\Http\Requests\Backend\Headquarters\Game\IndexDoRequest;
use App\Http\Requests\Backend\Headquarters\Game\StatusDoRequest;
use App\Http\SingleActions\Backend\Headquarters\Game\AddDoAction;
use App\Http\SingleActions\Backend\Headquarters\Game\DelDoAction;
use App\Http\SingleActions\Backend\Headquarters\Game\EditDoAction;
use App\Http\SingleActions\Backend\Headquarters\Game\GetSearchConditionAction;
use App\Http\SingleActions\Backend\Headquarters\Game\IndexDoAction;
use App\Http\SingleActions\Backend\Headquarters\Game\StatusDoAction;
use Illuminate\Http\JsonResponse;

/**
 * Class BackendGameController
 * @package App\Http\Controllers\BackendApi\Headquarters
 */
class BackendGameController extends BackEndApiMainController
{
    /**
     * @param AddDoAction $action  Action.
     * @param AddRequest  $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function addDo(AddDoAction $action, AddRequest $request) :JsonResponse
    {
        $inputDatas = $request->validated();
        return $action->execute($this, $inputDatas);
    }

    /**
     * @param EditDoAction $action  Action.
     * @param EditRequest  $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function editDo(EditDoAction $action, EditRequest $request) :JsonResponse
    {
        $inputDatas = $request->validated();
        return $action->execute($this, $inputDatas);
    }

    /**
     * @param IndexDoAction  $action  Action.
     * @param IndexDoRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function indexDo(IndexDoAction $action, IndexDoRequest $request) :JsonResponse
    {
        $inputDatas = $request->validated();
        return $action->execute($this, $inputDatas);
    }

    /**
     * @param DelDoAction $action  Action.
     * @param DelRequest  $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function delDo(DelDoAction $action, DelRequest $request) :JsonResponse
    {
        $inputDatas = $request->validated();
        return $action->execute($inputDatas);
    }

    /**
     * @param GetSearchConditionAction $action Action.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function getSearchCondition(GetSearchConditionAction $action):JsonResponse
    {
        return $action->execute();
    }

    /**
     * @param StatusDoAction  $action  Action.
     * @param StatusDoRequest $request Request.
     * @return JsonResponse
     * @throws \Exception Exception.
     */
    public function statusDo(StatusDoAction $action, StatusDoRequest $request):JsonResponse
    {
        $inputDatas = $request->validated();
        return $action->execute($inputDatas);
    }
}
