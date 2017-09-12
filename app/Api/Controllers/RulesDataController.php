<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ConsolidatedRuleService;

class RulesDataController extends ApiBtgController
{
    private $userHelper;
    private $consolidatedRuleService;

    public function __construct(ConsolidatedRuleService $consolidatedRuleService, UserHelper $userHelper)
    {
        $this->consolidatedRuleService = $consolidatedRuleService;
        $this->userHelper  = $userHelper;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-26]
     * @return  Json
     */
    public function show($ruleId)
    {
        return $this->consolidatedRuleService->getDataRules($this->userHelper,$ruleId);
    }
}
