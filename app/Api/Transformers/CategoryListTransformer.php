<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class CategoryListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transformMultiple(\illuminate\Support\Collection $categoryCollection, $totalCount) 
    {
        $categoryCollection->transform(
            function ($category) {
                $this->categories[] = [
                    'id' => $category->id_sub_categoria,
                    'name' => $category->nm_sub_categoria
                ];
            }
        );

        $jsonCollection['count'] = $categoryCollection->count();
        $jsonCollection['total'] = $totalCount;
        $jsonCollection['result'] = $this->categories;

        return $jsonCollection;
    }
}