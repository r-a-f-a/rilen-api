<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;

class SourceTransformer extends HydratorAbstract
{

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-22]
     * @param   \illuminate\Support\Collection $tableSourceId
     * @return  Json
     */
    public function transform(\illuminate\Support\Collection $tableSourceId)
    {
        $tableSourceId->transform(
            function ($collection){
                $this->collectionHydrator = $collection->tableSourceId;
            }
        );

        return $this->collectionHydrator;
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-22]
     * @param   \illuminate\Support\Collection $sourceCollection
     * @return  Json
     */
   public function transformOptionsSource(\illuminate\Support\Collection $sourceCollection)
   {
       unset($this->collectionHydrator);
       $sourceCollection->transform(
           function ($collection){
               $this->collectionHydrator[] = $collection;
           }
       );

       return $this->collectionHydrator;
   }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-22]
     * @param   \illuminate\Support\Collection $sourceCollection
     * @return  Json
     */
    public function transformOptionsSourceTable(\illuminate\Support\Collection $sourceCollection)
    {
        $sourceCollection->transform(
            function ($collection){
                $this->collectionHydrator = [
                    'connection' => $collection->connection,
                    'table' => $collection->table,
                    'aliasField'=> $collection->aliasField,
                    'valueField'=> $collection->valueField,
                    'where' => $collection->where,
                    'order' => $collection->order,
                    'limit' => $collection->limit,
                ];
            }
        );

        return $this->collectionHydrator;
    }

}
