<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\RuleService;

class RulesListController extends ApiBtgController
{
    private $userHelper;
    private $ruleService;

    public function __construct(RuleService $ruleService, UserHelper $userHelper)
    {
        $this->ruleService = $ruleService;
        $this->userHelper  = $userHelper;
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2016-02-13]
    * @return  Json
    */
    public function show($ruleId)
    {
        return $this->ruleService->getConsolidatedRules($this->userHelper, $ruleId);
    }
}
