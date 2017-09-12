<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\UserRuleService;
use Illuminate\Http\Request;

class ConfigsController extends ApiBtgController
{
    private $userHelper;
    private $userRuleService;

    public function __construct(UserRuleService $userRuleService, UserHelper $userHelper)
    {
        $this->userRuleService = $userRuleService;
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
        return $this->userRuleService->updatePriorities($this->userHelper, $request->get('rules'));
    }

    public function index() {
        return $this->userRuleService->getPriorities($this->userHelper);
    }
}
