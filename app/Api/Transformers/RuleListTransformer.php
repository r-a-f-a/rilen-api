<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\RuleModel;
use Api\Hydrators\HydratorAbstract;

class RuleListTransformer extends HydratorAbstract
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2016-02-21]
    * @param   \illuminate\Support\Collection $ruleListCollection
    * @param   array $multipleTransform
    * @todo    Refactor pending
    * @return  Json
    */
    public function transformMultiple(\illuminate\Support\Collection $ruleListCollection, $multipleTransform)
    {

        $ruleListCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'name'      => $collection->name,
                    'status'    => $collection->status,
                    'data'      => $collection->data,
                    'version'   => $collection->version
                ];
            }
        );


        foreach ($this->collectionHydrator as $key => $collection) {
            // setKey
            $this->arrayKeyConfig = $collection['name'];

            // Individual key
            if (!isset($this->collectionTransformer[$this->arrayKeyConfig])) {
                $this->collectionTransformer[$this->arrayKeyConfig]['name'] = $collection['name'];
                //$this->collectionTransformer[$this->arrayKeyConfig]['icon'] = $collection['icon'];
            }

            // boolean key
            if($collection['status'] == TurnType::OFF) {
                $this->arrayBoolConfig = false;
            }

            // data key
            $json = $collection['data'];
            $result = json_decode($json);

            $transform = [
                'id'  	    => $collection['id'],
                'status'    => $this->arrayBoolConfig,
                'version'   => $collection['version'],
                'module'    => (isset($result->module->selected->alias))? $result->module->selected->alias : '',
                'name'      => (isset($result->configs->ruleName))? $result->configs->ruleName : '',
                'subject'   => (isset($result->configs->subject))? $result->configs->subject : '',
                'pealTotal' => $multipleTransform['pealTotal']
            ];

            // name key principle
            $this->collectionTransformer[$this->arrayKeyConfig]['rules'][] = $transform;
        }

        foreach($this->collectionTransformer as $groupCollection) {
            // keys fixed result one or multiple []
            $jsonCollection['count'] = $ruleListCollection->count();
            $jsonCollection['result'] = $groupCollection;
        }

        return $jsonCollection;
    }/**
    * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2016-02-21]
    * @param   \illuminate\Support\Collection $pealsListCollection
    * @return  Json
    */
    public function transformPeals(\illuminate\Support\Collection $pealsListCollection)
    {

        $pealsListCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'name'      => $collection->name,
                    'status'    => $collection->status,
                    'data'      => $collection->data,
                    'version'   => $collection->version
                ];
            }
        );


        foreach ($this->collectionHydrator as $key => $collection) {
            // setKey
            $this->arrayKeyConfig = $collection['name'];

            // Individual key
            if (!isset($this->collectionTransformer[$this->arrayKeyConfig])) {
                $this->collectionTransformer[$this->arrayKeyConfig]['name'] = $collection['name'];
            }
            // data key
            $json = $collection['data'];
            $result = json_decode($json);

            $transform = [
                'id'  	    => $collection['id'],
                'status'    => (bool) $collection['status'],
                'version'   => $collection['version'],
                'module'    => (isset($result->module->selected->alias))? $result->module->selected->alias : '',
                'name'      => (isset($result->configs->ruleName))? $result->configs->ruleName : '',
                'interval'      => (isset($result->configs->interval))? $result->configs->interval : '',
                'subject'   => (isset($result->configs->subject))? $result->configs->subject : '',
            ];

            // name key principle
            $this->collectionTransformer[$this->arrayKeyConfig]['rules'][] = $transform;
        }

        foreach($this->collectionTransformer as $groupCollection) {
            // keys fixed result one or multiple []
            $jsonCollection['count'] = $pealsListCollection->count();
            $jsonCollection['result'] = $groupCollection;
        }

        return $jsonCollection;
    }
}
