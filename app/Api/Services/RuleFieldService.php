<?php

namespace Api\Services;

use Api\Filters\HeaderFilter;
use Api\Models\FieldRuleModel;
use Api\Models\OptionsFieldModel;
use Api\Transformers\RuleFieldTransformer;
use Api\Transformers\SourceTransformer;
use Api\Helpers\UserHelper;
use Api\Models\RuleModel;


class RuleFieldService
{
    private $sourceTransformer;
    private $fieldRuleModel;
    private $optionsFieldModel;
    private $ruleFieldTransformer;
    private $userHelper;
    private $headerFilter;
    private $ruleModel;

    public function __construct(
        FieldRuleModel $fieldRuleModel,
        OptionsFieldModel $optionsFieldModel,
        RuleFieldTransformer $ruleFieldTransformer,
        SourceTransformer    $sourceTransformer,
        UserHelper $userHelper,
        HeaderFilter $headerFilter,
        RuleModel $ruleModel
    ) {
        $this->fieldRuleModel        = $fieldRuleModel;
        $this->optionsFieldModel     = $optionsFieldModel;
        $this->ruleFieldTransformer  = $ruleFieldTransformer;
        $this->sourceTransformer     = $sourceTransformer;
        $this->userHelper            = $userHelper;
        $this->headerFilter          = $headerFilter;
        $this->ruleModel             = $ruleModel;
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-21]
     * @param   int $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getFieldRules($ruleId)
    {
        $typeGroupsId=$this->ruleModel->getRuleGroups($ruleId);
        $groupsId = $this->ruleFieldTransformer->transformGroups($typeGroupsId);
        $fieldsRule = $this->fieldRuleModel->getObjectsGroups($groupsId);

        if ($fieldsRule->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $collectionField = $this->ruleFieldTransformer->transform($fieldsRule);
        $collectionFieldTransformer = $this->collectionFieldTransformer($collectionField);

        return $collectionFieldTransformer;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   $collectionField
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function collectionFieldTransformer($collectionField){

        foreach ($collectionField as $key => $collection) {
            $collectionFieldTransformer['fields'][$key] = $this->ruleFieldTransformer->fieldDefault($collection);

            if(isset($collection['sourceId'])){
                $tableSourceId = $this->getTableSourceId($collection['sourceId']);
                if($tableSourceId){
                    $sourcesCollection = $this->getOptionTableSource($collection['sourceId']);
                }else {
                    $sourcesCollection = $this->optionsFieldModel->getOptionsSources($collection['sourceId']);
                }
                $optionsSource = $this->sourceTransformer->transformOptionsSource($sourcesCollection);
                $collectionFieldTransformer['fields'][$key]['options'] = $optionsSource;
            }
        }
        return $collectionFieldTransformer;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   $sourceId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getOptionTableSource($sourceId){

        $configTableSourcesCollection = $this->optionsFieldModel->getConfigTableSource($sourceId);

        $tableSource = $this->sourceTransformer->transformOptionsSourceTable($configTableSourcesCollection);

        $tableSource = $this->replaceIdAllin($tableSource);

        $sourcesCollection = $this->optionsFieldModel->getOptionsTableSource($tableSource);

        return $sourcesCollection;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   int $sourceId
     * @return  array $tableSourceId
     */
    public function getTableSourceId($sourceId){

        $tableSourceIdCollection = $this->optionsFieldModel->getTableSourceId($sourceId);

        $tableSourceId = $this->sourceTransformer->transform($tableSourceIdCollection);

        return $tableSourceId;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   array $tableSource
     * @return  array $tableSource
     */
    public function replaceIdAllin($tableSource){

        $tableSource['where'] = str_replace('{idAllin}',$this->userHelper->getUserIdAlliN(),$tableSource['where']);

        return $tableSource;
    }
}
