<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Admin\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use App\Admin\Requests\AdministratorRequest;
use App\Admin\Resources\AdministratorResource;
use Facade\FlareClient\Http\Exceptions\NotFound;

class AdministratorController extends BackendController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->data(AdministratorResource::collection(Administrator::paginate(15)))->success();
    }

    /**
     * @param AdministratorRequest $request
     * @return JsonResponse
     */
    public function store(AdministratorRequest $request)
    {
        $admin = Administrator::create($this->params($request));
        return $this->data(new AdministratorResource($admin))->success();
    }

    /**
     * @param Administrator $admin
     * @return JsonResponse
     */
    public function show(Administrator $admin)
    {
        return $this->data(new AdministratorResource($admin))->success();
    }

    /**
     * @param AdministratorRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AdministratorRequest $request, $id)
    {
        try {
            $admin = Administrator::where('id', $id)->first();
            if (is_null($admin)) {
                throw new NotFound('Not found admin.');
            }
            $admin->update($this->params($request));
            return $this->data(new AdministratorResource($admin))->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if ($admin = Administrator::find($id)) {
            $admin->delete();
        }
        return $this->success();
    }

    /**
     * @param AdministratorRequest $request
     * @return array
     */
    protected function params(AdministratorRequest $request)
    {
        $params = $request->only(['username', 'name', 'password', 'avatar']);
        if (!empty($params['password'])) {
            $params['password'] = Hash::make($request->password);
        }
        return $params;
    }

}
