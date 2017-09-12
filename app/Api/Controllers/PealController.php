<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\PealService;

class PealController extends ApiBtgController
{
    private $userHelper;
    private $pealService;

    public function __construct(PealService $pealService, UserHelper $userHelper)
    {
        $this->pealService = $pealService;
        $this->userHelper  = $userHelper;
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-03-02]
    * @return  Json
    */
    public function show($pealId)
    {
        return $this->pealService->getPealById($this->userHelper, $pealId);
    }
}
