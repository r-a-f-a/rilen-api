<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\DepartmentListService;
use Illuminate\Http\Request;

class DepartmentListController extends ApiBtgController
{
    private $userHelper;
    private $departmentListService;

    public function __construct(DepartmentListService $departmentListService, UserHelper $userHelper)
    {
        $this->departmentListService = $departmentListService;
        $this->userHelper  = $userHelper;
    }

    /**
    * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2016-06-22]
    * @return  Json
    */
    public function store(Request $request) {
        return $this->departmentListService->getDepartments($this->userHelper, $request->only('query', 'offset', 'limit'));
    }
}