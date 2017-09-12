<?php

namespace Api\Transformers;

use Api\Models\RuleModel;
use Api\Types\ResultType;
use Api\Hydrators\HydratorAbstract;

class RuleTypeTransformer extends HydratorAbstract
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2016-02-22]
    * @param   \illuminate\Support\Collection $ruleTypeCollection
    * @return  Json
    */
    public function transform(\illuminate\Support\Collection $ruleTypeCollection)
    {
        $ruleTypeCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'name' => $collection->name
                ];
            }
        );

        foreach ($this->collectionHydrator as $key => $collection) {
            $this->collectionTransformer['name'] = $collection['name'];
        }

        foreach($this->collectionTransformer as $groupCollection) {
            $jsonCollection['count']    = ResultType::NOT_RESULT;
            $jsonCollection['result'][] = ['name' => $groupCollection];
        }

        return $jsonCollection;
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-27]
     * @param   \illuminate\Support\Collection $ruleVersionCollection
     * @return  Json
     */
    public function transformVersion(\illuminate\Support\Collection $ruleVersionCollection)
    {
        $ruleVersionCollection->transform(
            function ($collection) {
                $this->collectionHydrator = [
                    'id'      => $collection->id,
                    'version' => $collection->version
                ];
            }
        );

        return $this->collectionHydrator;
    }


}
