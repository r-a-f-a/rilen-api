<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\PealModel;
use Api\Hydrators\HydratorAbstract;

class PealTransformer extends HydratorAbstract
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2017-03-02]
    * @param   \illuminate\Support\Collection $pealCollection
    * @todo    Refactor pending
    * @return  Json
    */
    public function transform(\illuminate\Support\Collection $pealCollection)
    {
        $pealCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'name'      => $collection->name,
                    'status'    => $collection->status,
                    'data'      => $collection->data,
                    'version'   => $collection->version,
                    'icon'      => $collection->icon,
                ];
            }
        );

        foreach ($this->collectionHydrator as $key => $collection) {
            // setKey
            $this->arrayKeyConfig = $collection['name'];

            // Individual key
            if (!isset($this->collectionTransformer[$this->arrayKeyConfig])) {
                $this->collectionTransformer[$this->arrayKeyConfig]['name'] = $collection['name'];
                $this->collectionTransformer[$this->arrayKeyConfig]['icon'] = $collection['icon'];
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
                'module'    => $result->module,
                'name'      => $result->name,
                'subject'   => $result->subject
            ];

            // name key principle
            $this->collectionTransformer[$this->arrayKeyConfig]['rules'][] = $transform;
        }

        foreach($this->collectionTransformer as $groupCollection) {
            // keys fixed result one or multiple []
            $jsonCollection['count'] = $pealCollection->count();
            $jsonCollection['result'] = $groupCollection;
        }

        return $jsonCollection;
    }
}
