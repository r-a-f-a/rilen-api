<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\UserRuleService;
use Illuminate\Http\Request;

class RulesAllController extends ApiBtgController
{
    private $userHelper;
    private $userRuleService;

    public function __construct(UserRuleService $userRuleService, UserHelper $userHelper)
    {
        $this->userRuleService = $userRuleService;
        $this->userHelper  = $userHelper;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-28]
     * @return  Json
     */
    public function store(Request $request)
    {
        return $this->userRuleService->getAllRuleActive($this->userHelper,$request->get('status'));
    }

}
