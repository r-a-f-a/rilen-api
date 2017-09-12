<?php

namespace Api\Services;

use Api\Transformers\BrandListTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\BrandListModel;

class BrandListService
{
    public function __construct(
        BrandListTransformer $brandListTransformer,
        BrandListModel $brandListModel,
        HeaderFilter $headerFilter
    ) {
        $this->brandListTransformer = $brandListTransformer;
        $this->brandListModel = $brandListModel;
        $this->headerFilter = $headerFilter;
    }

    /**
    * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-23]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   array $parameters
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getBrands(\Api\Helpers\UserHelper $userHelper, $parameters) {
        $query = trim($parameters['query']);
        $offset = isset($parameters['offset']) ? $parameters['offset'] : 0;
        $limit = isset($parameters['limit']) ? $parameters['limit'] : 10;

        $brands = $this->brandListModel->getBrands($userHelper, $query, $offset, $limit);

        if ($brands->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $totalCount = $this->brandListModel->getBrandsCount($userHelper, $query);

        return $this->brandListTransformer->transformMultiple($brands, $totalCount);
    }
}
