<?php

namespace Api\Services;

use Api\Models\UserRuleModel;
use Api\Models\ConsolidatedRuleModel;
use Api\Services\ConsolidatedRuleService;
use Api\Transformers\RuleAllTransformer;
use Api\Filters\HeaderFilter;
use Api\Transformers\ConfigsTransformer;

class UserRuleService
{
    private $headerFilter;
    private $userRuleModel;
    private $consolidatedRuleModel;
    private $consolidatedRuleService;
    private $ruleAllTransformer;

    public function __construct(
        UserRuleModel $userRuleModel,
        ConsolidatedRuleModel $consolidatedRuleModel,
        HeaderFilter $headerFilter,
        ConsolidatedRuleService $consolidatedRuleService,
        ConfigsTransformer $configsTransformer,
        RuleAllTransformer $ruleAllTransformer
    )
    {
        $this->headerFilter = $headerFilter;
        $this->userRuleModel = $userRuleModel;
        $this->consolidatedRuleModel = $consolidatedRuleModel;
        $this->consolidatedRuleService = $consolidatedRuleService;
        $this->configsTransformer = $configsTransformer;
        $this->ruleAllTransformer = $ruleAllTransformer;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-26]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  bool
     */
    public function ruleSave(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        if (empty($parameters)) {
            return $this->headerFilter->getEmptyResult();
        }
        if (!isset($parameters['id'])) {
            $this->userRuleModel->ruleId = $parameters['ruleId'];
            $this->userRuleModel->pealFrom = ($parameters['peal'] ? $parameters['peal'] : 0);
            $this->userRuleModel->userId = $userHelper->getUserId();
            $this->userRuleModel->priority = $this->getMaxOrder($userHelper);
            $this->userRuleModel->status = 1;
            $this->userRuleModel->timestamps = false;
            $this->userRuleModel->setIncrementing(true);
            $return = $this->userRuleModel->save();
            if ($return === false) {
                return response()->json(['status' => $return], 400);
            }
            $parameters['id'] = $this->userRuleModel->getAttribute('id');
        }
        $result = $this->consolidatedRuleService->consolidatedRuleSave($userHelper, $parameters);
        return response()->json(['status' => $result], $result ? 200 : 400);
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since [2017-06-26]
     * @param \Api\Helpers\UserHelper $userHelper
     * @return int
     */
    function getMaxOrder(\Api\Helpers\UserHelper $userHelper)
    {
        $orderCollection = $this->userRuleModel->getMaxRuleOrderByUser($userHelper);

        if ($orderCollection->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $orderCollection[0];
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-29]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   $status
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRuleActive(\Api\Helpers\UserHelper $userHelper, $status)
    {

        $status = isset($status) ? $status : null;

        $ruleCollection = $this->userRuleModel->getAllRuleActive($userHelper, $status);

        if ($ruleCollection->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->ruleAllTransformer->transform($ruleCollection);

    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-28]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function updatePriorities(\Api\Helpers\UserHelper $userHelper, $rules)
    {

        if (!isset($rules)) {
            return $this->headerFilter->getEmptyResult();
        }

        $rulesJson = json_decode($rules, true);
        $results = [];

        foreach ($rulesJson as $rule) {
            $result = $this->userRuleModel->updatePriority($userHelper, $rule);

            $status = $result > 0;

            if (!$status && $this->userRuleModel->existUserRule($userHelper, $rule["id"])) {
                $status = true;
            }

            $results[] = ["id" => $rule["id"], "status" => $status];
        }

        return ["results" => $results];
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-28]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getPriorities(\Api\Helpers\UserHelper $userHelper)
    {
        $result = $this->userRuleModel->getPriorities($userHelper);
        if ($result->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->configsTransformer->transform($result);
    }

    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-26]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  bool
     */
    public function ruleStatus(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        if (empty($parameters)) {
            return $this->headerFilter->getEmptyResult();
        }
        $return = $this->userRuleModel->where('id', '=', $parameters['id'])->update(['status' => ($parameters['status'] == 'true' ? 1 : 0)]);

        if ($return === false) {
            return response()->json(['status' => $return], 400);
        }

        return response()->json(['status' => $return], $return ? 200 : 400);
    }

}
