<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\ConfigModel;
use Api\Hydrators\HydratorAbstract;

class ConfigTransformer extends HydratorAbstract
{

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2017-06-27]
    * @param   \illuminate\Support\Collection $themeCollection
    * @return  Json
    */
    public function transform(\illuminate\Support\Collection $configCollection)
    {
        $configCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'btg'       => boolval($collection->btg),
                    'limit'     => $collection->limit,
                    'vmta'      => $collection->vmta
                ];
            }
        );
        
        foreach ($this->collectionHydrator as $key => $collection) {
            $jsonCollection = $collection;
        }
         
        return $jsonCollection;    
    }
  
    

}
