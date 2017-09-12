<?php

namespace Api\Services;

use Api\Models\RuleModel;
use Api\Transformers\RuleDataTransformer;
use Api\Models\ConsolidatedRuleModel;
use Api\Filters\HeaderFilter;

class ConsolidatedRuleService
{
    private $headerFilter;
    private $ruleDataTransformer;
    private $consolidatedRuleModel;

    public function __construct(
        ConsolidatedRuleModel $consolidatedRuleModel,
        RuleDataTransformer $ruleDataTransformer,
        HeaderFilter $headerFilter
    )
    {
        $this->headerFilter = $headerFilter;
        $this->consolidatedRuleModel = $consolidatedRuleModel;
        $this->ruleDataTransformer = $ruleDataTransformer;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  bool
     */
    public function consolidatedRuleSave(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        $result = false;
        if ($this->validConsolidatedRuleData($userHelper, $parameters)) {
            $version = $this->getActiveRuleVersion($userHelper, $parameters['id']);
            $this->consolidatedRuleModel = new ConsolidatedRuleModel();
            $this->consolidatedRuleModel->setTable("consolidated_rules");
            $this->consolidatedRuleModel->version = $version;
            $this->consolidatedRuleModel->data =  $this->consolidatedParams($userHelper, $parameters);
            $this->consolidatedRuleModel->userRuleId = $parameters['id'];
            $this->consolidatedRuleModel->status = 1;
            $this->consolidatedRuleModel->setIncrementing(true);
            $result = $this->consolidatedRuleModel->save();
        }

        return $result;
    }

    public function consolidatedParams(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        $data = collect(json_decode($parameters['data'], true))->except(['version','created_at','account','rule'])->toArray();
        $ruleModel = new RuleModel();
        $data['rule'] = $ruleModel->getRule($parameters['ruleId'])->first()->toArray();
        $data['account'] =  (array) $userHelper->getUser();
        return json_encode($data);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  bool
     */
    public function validConsolidatedRuleData(\Api\Helpers\UserHelper $userHelper, $parameters)
    {

        $return = true;

        $exists = $this->consolidatedRuleModel->getDataRules(
            $userHelper,
            $parameters['id']
        );
        if (!$exists->isEmpty()) {
            if (md5($exists[0]['data']) == md5($parameters['data'])) {
                $return = false;
            }
        }

        return $return;
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since [2017-06-26]
     * @param \Api\Helpers\UserHelper $userHelper
     * @param $ruleId
     * @return string
     */
    function getActiveRuleVersion($userHelper, $ruleId)
    {
        $version = '1.0';

        $versionCollection = $this->consolidatedRuleModel->getActiveRuleVersion($userHelper, $ruleId);

        if (!$versionCollection->isEmpty()) {
            $version = number_format($versionCollection[0]['version'] + 0.1, 1);
            $this->consolidatedRuleModel->alterStatusRuleConsolidated($versionCollection[0]['id'], '0');
        }

        return $version;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-26]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   int $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getDataRules(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {
        $consolidatedDataRule = $this->consolidatedRuleModel->getDataRules(
            $userHelper,
            $ruleId
        );

        if ($consolidatedDataRule->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->ruleDataTransformer->transformData($consolidatedDataRule);

    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since [2017-06-26]
     * @param \Api\Helpers\UserHelper $userHelper
     * @param $ruleId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRuleVersion($userHelper, $ruleId)
    {

        $versionCollection = $this->consolidatedRuleModel->getAllRuleVersion($userHelper, $ruleId);

        if ($versionCollection->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $transformVersionCollection['version'] = $this->ruleDataTransformer->transformVersion($versionCollection);

        return $transformVersionCollection;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since [2017-06-28]
     * @param \Api\Helpers\UserHelper $userHelper
     * @param $parameters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function updateStatusRuleVersion($userHelper, $parameters)
    {
        $result = $this->consolidatedRuleModel->inactiveRuleConsolidatedByRuleId($userHelper, $parameters['ruleId']);
        if ($result > 0) {
            $result = $this->consolidatedRuleModel->alterStatusRuleConsolidated($parameters['consolidatedId'], 1);
        }

        return response()->json(['status' => $result > 0], $result > 0 ? 200 : 400);
    }
}
