<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class SubCategoryListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transformMultiple(\illuminate\Support\Collection $subCategoryCollection, $totalCount) 
    {
        $subCategoryCollection->transform(
            function ($subCategory) {
                $this->subCategories[] = [
                    'id' => $subCategory->id_ss_categoria,
                    'name' => $subCategory->nm_ss_categoria
                ];
            }
        );

        $jsonCollection['count'] = $subCategoryCollection->count();
        $jsonCollection['total'] = $totalCount;
        $jsonCollection['result'] = $this->subCategories;

        return $jsonCollection;
    }
}