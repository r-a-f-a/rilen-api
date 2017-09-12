<?php

namespace Api\Services;

use Api\Transformers\SubCategoryListTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\SubCategoryListModel;

class SubCategoryListService
{
    public function __construct(
        SubCategoryListTransformer $subCategoryListTransformer,
        SubCategoryListModel $subCategoryListModel,
        HeaderFilter $headerFilter
    ) {
        $this->subCategoryListTransformer = $subCategoryListTransformer;
        $this->subCategoryListModel = $subCategoryListModel;
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
    public function getSubCategories(\Api\Helpers\UserHelper $userHelper, $parameters) {
        $idSubCategory = $parameters['sub_category'];
        $query = trim($parameters['query']);
        $offset = isset($parameters['offset']) ? $parameters['offset'] : 0;
        $limit = isset($parameters['limit']) ? $parameters['limit'] : 10;

        $subCategories = $this->subCategoryListModel->getSubCategories($userHelper, $idSubCategory, $query, $offset, $limit);

        if ($subCategories->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $totalCount = $this->subCategoryListModel->getSubCategoriesCount($userHelper, $idSubCategory, $query);

        return $this->subCategoryListTransformer->transformMultiple($subCategories, $totalCount);
    }
}