<?php

namespace Api\Services;

use Api\Transformers\RuleListTransformer;
use Api\Transformers\RuleTypeTransformer;
use Api\Transformers\RuleTransformer;
use Api\Models\UserRuleModel;
use Api\Filters\HeaderFilter;
use Api\Models\RuleModel;
use Api\Types\UserType;
use Api\Types\PealType;

class RuleService
{
    private $ruleModel;
    private $headerFilter;
    private $queryConfig;
    private $ruleTransformer;
    private $ruleListTransformer;
    private $ruleTypeTransformer;
    private $userRuleModel;

    public function __construct(
        UserRuleModel $userRuleModel,
        RuleModel $ruleModel,
        RuleTransformer $ruleTransformer,
        RuleListTransformer $ruleListTransformer,
        RuleTypeTransformer $ruleTypeTransformer,
        HeaderFilter $headerFilter
    ) {
        $this->ruleModel             = $ruleModel;
        $this->headerFilter          = $headerFilter;
        $this->ruleTransformer       = $ruleTransformer;
        $this->userRuleModel         = $userRuleModel;
        $this->ruleListTransformer   = $ruleListTransformer;
        $this->ruleTypeTransformer   = $ruleTypeTransformer;
        $this->queryConfig           = $this->ruleModel->notHomologation();
    }

    /**
     * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-02-20]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   int $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getConsolidatedRules(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {
        $consolidatedRule = $this->userRuleModel->getConsolidatedRulesNotPeal(
            $userHelper,
            $ruleId,
            PealType::PEAL_FAILED
        );

        $consolidatedRulePeal = $this->userRuleModel->getConsolidatedRulesPeal(
            $userHelper,
            $ruleId
        );



        $multipleTransform = ['pealTotal' => $consolidatedRulePeal->count()];

        $typeNameRule = $this->ruleModel->getRuleName($ruleId);

        if ($consolidatedRule->isEmpty()) {
            if($typeNameRule->isEmpty()) {
                return $this->headerFilter->getEmptyResult();
            }

            return $this->ruleTypeTransformer->transform($typeNameRule);
        }

        return $this->ruleListTransformer->transformMultiple(
            $consolidatedRule,
            $multipleTransform
        );
    }


    public function getConsolidatedPeals(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {
        $consolidatedRulePeal = $this->userRuleModel->getConsolidatedRulesPeal(
            $userHelper,
            $ruleId
        );


        if ($consolidatedRulePeal->isEmpty()) {
                return $this->headerFilter->getEmptyResult();
        }


        return $this->ruleListTransformer->transformPeals(
            $consolidatedRulePeal
        );
    }

    /**
     * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-02-14]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function rulesConfig(\Api\Helpers\UserHelper $userHelper)
    {
        if ($userHelper->isHomologation() == UserType::HOMOLOGATION_SUCCESS) {
            $this->queryConfig = $this->ruleModel->isHomologation();
        }
        return $this->ruleTransformer->transform($this->queryConfig);
    }



    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-08-21]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function rulesConfigByID(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {
        if ($userHelper->isHomologation() == UserType::HOMOLOGATION_SUCCESS) {
            $this->queryConfig = $this->ruleModel->getRule($ruleId);
        }
        return $this->ruleTransformer->transformRule($this->queryConfig);
    }


    public function rulesDelete(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {
        if (!isset($ruleId)) {
            return $this->headerFilter->getEmptyResult();
        }
        $result['status'] = (bool)$this->userRuleModel->deleteRule($userHelper, $ruleId);
        return $result;
    }

}
