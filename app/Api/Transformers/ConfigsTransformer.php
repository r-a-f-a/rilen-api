<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class ConfigsTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transform(\illuminate\Support\Collection $configsCollection) 
    {
        $configsCollection->transform(
            function ($config) {
                $json = json_decode($config->data, true);
                $this->configs[] = [
                    'id' => $config->id,
                    'type' => $config->name,
                    'name' => isset($json['configs']['ruleName']) ? $json['configs']['ruleName'] : null,
                    'priority' => $config->priority,
                    'hour' => isset($json['configs']['hour']) ? $json['configs']['hour'] : null,
                    'subject' => isset($json['configs']['subject']) ? $json['configs']['subject'] : null
                ];
            }
        );

        $jsonCollection['count'] = $configsCollection->count();
        $jsonCollection['result'] = $this->configs;

        return $jsonCollection;
    }
}