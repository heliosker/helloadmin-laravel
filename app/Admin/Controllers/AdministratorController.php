<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Admin\Models\Administrator;
use App\Admin\Resources\AdministratorResource;
use App\Admin\Controllers\AdminController;

class AdministratorController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->data(AdministratorResource::collection(Administrator::paginate(15)))->success();
    }


}
