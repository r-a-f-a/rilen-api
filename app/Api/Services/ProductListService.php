<?php

namespace Api\Services;

use Api\Transformers\ProductListTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\ProductListModel;

class ProductListService
{
    public function __construct(
        ProductListTransformer $productListTransformer,
        ProductListModel $productListModel,
        HeaderFilter $headerFilter
    ) {
        $this->productListTransformer = $productListTransformer;
        $this->productListModel = $productListModel;
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
    public function getProducts(\Api\Helpers\UserHelper $userHelper, $parameters, $html = false) {
        $query = isset($parameters['query']) ? trim($parameters['query']) : "";
        $offset = isset($parameters['offset']) ? $parameters['offset'] : 0;
        $limit = isset($parameters['limit']) ? $parameters['limit'] : 10;

        $products = $this->productListModel->getProducts($userHelper, $query, $offset, $limit, $html);

        if ($products->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $totalCount = $this->productListModel->getCountProducts($userHelper, $query);

        return $this->productListTransformer->transformMultiple($products, $totalCount, $html);
    }

    public function getRandom(\Api\Helpers\UserHelper $userHelper, $limit = 10)
    {
        $products = $this->productListModel->getRandProducts($userHelper, $limit);
        return $this->productListTransformer->transform($products);
    }
}