<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Menu;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\MenuRequest;
use App\Admin\Resources\MenuResource;
use Facade\FlareClient\Http\Exceptions\NotFound;

class MenuController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->data(Menu::tree())->success();
    }

    /**
     * Create menu
     *
     * @param MenuRequest $request
     * @return JsonResponse
     */
    public function store(MenuRequest $request)
    {
        $menu = Menu::create($request->only($this->getField()));
        return $this->data(new MenuResource($menu))->success();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $menu = Menu::where('id', $id)->first();
        return $this->data(new MenuResource($menu))->success();
    }

    /**
     * Update a menu
     *
     * @param MenuRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(MenuRequest $request, $id)
    {
        try {
            $menu = Menu::where('id', $id)->first();

            if (is_null($menu)) {
                throw new NotFound('Not found menu');
            }

            $menu->update($request->only($this->getField()));

            return $this->data(new MenuResource($menu))->success();

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if ($menu = Menu::find($id)) {
            $menu->delete();
        }
        return $this->success();
    }

    /**
     * @return string[]
     */
    private function getField()
    {
        return ['parent_id', 'title', 'icon', 'uri', 'show', 'roles', 'permissions'];
    }
}
