<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\CategoryListService;
use Illuminate\Http\Request;

class CategoryListController extends ApiBtgController
{
    private $userHelper;
    private $categoryListService;

    public function __construct(CategoryListService $categoryListService, UserHelper $userHelper)
    {
        $this->categoryListService = $categoryListService;
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
        return $this->categoryListService->getCategories($this->userHelper, $request->only('department', 'query', 'offset', 'limit'));
    }
}
