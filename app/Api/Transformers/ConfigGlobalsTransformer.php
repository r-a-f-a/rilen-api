<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\GlobalModel;
use Api\Hydrators\HydratorAbstract;

class ConfigGlobalsTransformer extends HydratorAbstract
{

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-27]
     * @param   \illuminate\Support\Collection $themeCollection
     * @return  Json
     */
    public function transform(\illuminate\Support\Collection $configGlobalsOptionsCollection)
    {
        $configGlobalsOptionsCollection->transform(
            function ($collection) {
                $this->collectionHydrator[$collection->name] = $collection->value;
            }
        );


        foreach ($this->collectionHydrator as $key => $collection) {
            $jsonCollection['data'][$key] = $collection;
        }

        $jsonCollection['globals'] = $this->getConfigGlobalsList();
        return $jsonCollection;
    }


    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-08-01]
     * @param   \illuminate\Support\Collection $globalCollection
     * @return  Json
     */
    public function globalTransform(\illuminate\Support\Collection $globalCollection)
    {
        foreach ($globalCollection as $key => $collection) {
                $transform = [
                    'id' => $collection['id'],
                    'name' => $collection['name'],
                    'title' => $collection['title'],
                    'type' => $collection['type'],
                ];
            $global = $transform;
        }
        return $global;
    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-28]
     * @return  Json
     */
    public function getConfigGlobalsList()
    {
        $globalModel = new GlobalModel();

        $configGlobalsList = $globalModel->getConfigGlobalsList();

        if ($configGlobalsList->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        foreach ($configGlobalsList as $key => $collection) {

            if ($collection['options'] == true) {

                $collectionOption = $this->getOptions($collection['globalsId']);
                $transform = [
                    'id' => $collection['id'],
                    'name' => $collection['name'],
                    'title' => $collection['title'],
                    'type' => $collection['type'],
                    'options' => $collectionOption,
                ];

            } else {
                $transform = [
                    'id' => $collection['id'],
                    'name' => $collection['name'],
                    'title' => $collection['title'],
                    'type' => $collection['type'],
                ];
            }
            $json[] = $transform;
        }
        return $json;
    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-28]
     * @return  Json
     */
    public function getOptions($globalsId)
    {
        $globalModel = new GlobalModel();

        $options = $globalModel->getOptions($globalsId);
        foreach ($options as $key => $option) {

            $transformoptions = [
                'id' => $option['id'],
                'alias' => $option['alias'],
                'value' => $option['value'],
            ];
            $json[] = $transformoptions;
        }
        return $json;

    }

}
