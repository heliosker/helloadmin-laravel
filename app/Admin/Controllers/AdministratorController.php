<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Admin\Models\Administrator;
use App\Admin\Resources\AdministratorResource;

class AdministratorController extends AdminController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->data(AdministratorResource::collection(Administrator::paginate(15)))->success();
    }


}
