<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\ThemeModel;
use Api\Hydrators\HydratorAbstract;

class ThemeTransformer extends HydratorAbstract
{
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Transformers]
    * @since   [2017-06-22]
    * @param   \illuminate\Support\Collection $themeCollection, bool $list
    * @todo    Refactor pending
    * @return  Json
    */
    //List is an optional parameter, used to set whether the return is a collection(False) or a list of collections(True)
    public function transform(\illuminate\Support\Collection $themeCollection, bool $list = false)
    {
        $themeCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'userId'    => $collection->userId,
                    'name'      => $collection->name,
                    'configs'   => $collection->configs,
                    'startAt'   => $collection->start_at,
                    'endAt'     => $collection->end_at,
                    'default'   => $collection->default,
                    'status'    => $collection->status,
                ];
            }
        );

        foreach ($this->collectionHydrator as $key => $collection) {
          $collection['configs'] = json_decode($collection['configs'],true);
          if($list == false){
            $jsonCollection['result'] = $collection;
            break;
          }
          $jsonCollection['count']= $themeCollection->count();
          $jsonCollection['result'][] = $collection;
        }
                 
        return $jsonCollection;
    }

}
