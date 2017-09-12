<?php

namespace Api\Services;

use Api\Transformers\CategoryListTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\CategoryListModel;

class CategoryListService
{
    public function __construct(
        CategoryListTransformer $categoryListTransformer,
        CategoryListModel $categoryListModel,
        HeaderFilter $headerFilter
    ) {
        $this->categoryListTransformer = $categoryListTransformer;
        $this->categoryListModel = $categoryListModel;
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
    public function getCategories(\Api\Helpers\UserHelper $userHelper, $parameters) {
        $idDepartment = $parameters['department'];
        $query = trim($parameters['query']);
        $offset = isset($parameters['offset']) ? $parameters['offset'] : 0;
        $limit = isset($parameters['limit']) ? $parameters['limit'] : 10;

        $categories = $this->categoryListModel->getCategories($userHelper, $idDepartment, $query, $offset, $limit);

        if ($categories->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $totalCount = $this->categoryListModel->getCategoriesCount($userHelper, $idDepartment, $query);

        return $this->categoryListTransformer->transformMultiple($categories, $totalCount);
    }
}