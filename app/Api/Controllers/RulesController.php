<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\RuleService;
use Api\Services\UserRuleService;
use Illuminate\Http\Request;

class RulesController extends ApiBtgController
{
    private $userHelper;
    private $ruleService;
    private $userRuleService;

    public function __construct(RuleService $ruleService, UserRuleService $userRuleService, UserHelper $userHelper)
    {
        $this->ruleService = $ruleService;
        $this->userRuleService = $userRuleService;
        $this->userHelper  = $userHelper;
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2016-02-13]
    * @return  Json
    */
    public function index()
    {
        return $this->ruleService->rulesConfig($this->userHelper);
    }

    public function store(Request $request)
    {
       return $this->userRuleService->ruleSave($this->userHelper,$request->only('id','data','ruleId','peal'));
    }

    public function show($ruleId) {
        return $this->ruleService->rulesConfigByID($this->userHelper, $ruleId);
    }

    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-08-21]
     * @return  Json
     */
    public function destroy($ruleId){
        return $this->ruleService->rulesDelete($this->userHelper, $ruleId);
    }


    public function status(Request $request){
        return $this->userRuleService->ruleStatus($this->userHelper, $request->only('status', 'id'));
    }
}
