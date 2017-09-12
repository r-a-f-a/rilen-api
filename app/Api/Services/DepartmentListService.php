<?php

namespace Api\Services;

use Api\Transformers\DepartmentListTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\DepartmentListModel;

class DepartmentListService
{
    public function __construct(
        DepartmentListTransformer $deparmentListTransformer,
        DepartmentListModel $departmentListModel,
        HeaderFilter $headerFilter
    ) {
        $this->deparmentListTransformer = $deparmentListTransformer;
        $this->departmentListModel = $departmentListModel;
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
    public function getDepartments(\Api\Helpers\UserHelper $userHelper, $parameters) {
        $query = trim($parameters['query']);
        $offset = isset($parameters['offset']) ? $parameters['offset'] : 0;
        $limit = isset($parameters['limit']) ? $parameters['limit'] : 10;

        $categories = $this->departmentListModel->getDepartments($userHelper, $query, $offset, $limit);

        if ($categories->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        $totalCount = $this->departmentListModel->getCountDepartments($userHelper, $query);

        return $this->deparmentListTransformer->transformMultiple($categories, $totalCount);
    }
}
