<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;


class RuleAllTransformer extends HydratorAbstract
{

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-29]
     * @param   \illuminate\Support\Collection $ruleCollection
     * @return  Json
     */
    public function transform(\illuminate\Support\Collection $ruleCollection)
    {
        $ruleCollection->transform(
            function ($collection) {

                $arrData = json_decode($collection->data,true);

                $this->collectionHydrator[] = [
                    'ruleId'     => $collection->ruleId,
                    'name'       => $collection->name,
                    'alias'      => $collection->alias,
                    'modules'    => (isset($arrData['module']['selected']['name']))? $arrData['module']['selected']['alias'] : '',
                    'order'      => $collection->order,
                    'subject'    => (isset($arrData['configs']['subject'])) ? $arrData['configs']['subject'] : '',
                    'version'    => $collection->version,
                    'status'     => $collection->status
                ];
            }
        );

        $collectionTransform['rules'] = $this->collectionHydrator;
        $collectionTransform['count'] = $ruleCollection->count();

        return $collectionTransform;
    }

}


