<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class BrandListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transformMultiple(\illuminate\Support\Collection $brandCollection, $totalCount)
    {
        $brandCollection->transform(
            function ($brand) {
                if ($brand->marca) {
                    $this->brands[] = [
                        'id' => $brand->id,
                        'name' => $brand->marca
                    ];
                }
            }
        );

        $jsonCollection['count'] = $brandCollection->count();
        $jsonCollection['total'] = $totalCount;
        $jsonCollection['result'] = $this->brands;

        return $jsonCollection;
    }
}
