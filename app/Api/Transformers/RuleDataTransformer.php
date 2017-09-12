<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;


class RuleDataTransformer extends HydratorAbstract
{

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-26]
     * @param   \illuminate\Support\Collection $consolidatedDataRule
     * @return  Json
     */
    public function transformData(\illuminate\Support\Collection $consolidatedDataRule)
    {
        $consolidatedDataRule->transform(
            function ($collection) {
                $this->collectionHydrator = [
                    'data'       => json_decode($collection->data),
                    'version'    => $collection->version,
                    'created_at' => $collection->created_at
                ];
            }
        );

        return $this->collectionHydrator;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-26]
     * @param   \illuminate\Support\Collection $consolidatedVersionRule
     * @return  Json
     */
    public function transformVersion(\illuminate\Support\Collection $consolidatedVersionRule)
    {
        $consolidatedVersionRule->transform(
            function ($collection) {
                $this->collectionHydrator[$collection->id] = [
                    'data'       => json_decode($collection->data),
                    'version'    => $collection->version,
                    'created_at' => $collection->created_at,
                    'updated_at' => $collection->updated_at,
                    'status'     => $collection->status
                ];
            }
        );

        return $this->collectionHydrator;
    }
}
