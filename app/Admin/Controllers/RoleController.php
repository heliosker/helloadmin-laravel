<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Role;
use App\Admin\Requests\RoleRequest;
use App\Admin\Resources\RoleResource;
use Illuminate\Http\JsonResponse;

class RoleController extends BackendController
{
    /**
     * Role list
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->data(RoleResource::collection(Role::paginate(15)))->success();
    }

    /**
     * Store a newly role created resource in storage.
     *
     * @param RoleRequest $request
     * @return JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only(['slug', 'name', 'permissions']));
        return $this->data(new RoleResource($role))->success();
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role)
    {
        return $this->data(new RoleResource($role))->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only(['slug', 'name', 'permissions']));
        return $this->data(new RoleResource($role))->success();
    }

    /**
     * Delete role
     *
     * @param Role $role
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->success();
    }
}
