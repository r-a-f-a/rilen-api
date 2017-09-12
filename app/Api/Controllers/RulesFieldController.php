<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\RuleFieldService;

class RulesFieldController extends ApiBtgController
{
    private $userHelper;
    private $ruleFieldService;

    public function __construct(RuleFieldService $ruleFieldService, UserHelper $userHelper)
    {
        $this->ruleFieldService = $ruleFieldService;
        $this->userHelper  = $userHelper;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function show($ruleId)
    {
        return $this->ruleFieldService->getFieldRules($ruleId);
    }
}
