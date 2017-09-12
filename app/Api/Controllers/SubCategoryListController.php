<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\SubCategoryListService;
use Illuminate\Http\Request;

class SubCategoryListController extends ApiBtgController
{
    private $userHelper;
    private $subCategoryListService;

    public function __construct(SubCategoryListService $subCategoryListService, UserHelper $userHelper)
    {
        $this->subCategoryListService = $subCategoryListService;
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
        return $this->subCategoryListService->getSubCategories($this->userHelper, $request->only('sub_category', 'query', 'offset', 'limit'));
    }
}
