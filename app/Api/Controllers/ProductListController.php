<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ProductListService;
use Illuminate\Http\Request;

class ProductListController extends ApiBtgController
{
    private $userHelper;
    private $productListService;

    public function __construct(ProductListService $productListService, UserHelper $userHelper)
    {
        $this->productListService = $productListService;
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
        return $this->productListService->getProducts($this->userHelper, $request->only('query', 'offset', 'limit'));
    }
}
