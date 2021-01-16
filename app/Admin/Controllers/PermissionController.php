<?php

namespace App\Admin\Controllers;

use App\Admin\Resources\PermissionResource;
use Illuminate\Http\Request;
use App\Admin\Models\Permission;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\PermissionRequest;

class PermissionController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->data(Permission::tree())->success();
    }

    /**
     * 添加权限
     *
     * @param PermissionRequest $request
     * @return JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create($request->only(['parent_id', 'slug', 'name', 'http_method', 'http_path']));

        return $this->data(new PermissionResource($permission))->success();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
