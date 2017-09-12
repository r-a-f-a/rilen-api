<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\BrandListService;
use Illuminate\Http\Request;

class BrandListController extends ApiBtgController
{
    private $userHelper;
    private $brandListService;

    public function __construct(BrandListService $brandListService, UserHelper $userHelper)
    {
        $this->brandListService = $brandListService;
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
        return $this->brandListService->getBrands($this->userHelper, $request->only('query', 'offset', 'limit'));
    }
}
