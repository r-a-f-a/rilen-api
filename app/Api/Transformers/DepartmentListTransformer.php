<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class DepartmentListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transformMultiple(\illuminate\Support\Collection $departmentCollection, $totalCount) 
    {
        $departmentCollection->transform(
            function ($department) {
                $this->departments[] = [
                    'id' => $department->id_categoria,
                    'name' => $department->nm_categoria
                ];
            }
        );

        $jsonCollection['count'] = $departmentCollection->count();
        $jsonCollection['total'] = $totalCount;
        $jsonCollection['result'] = $this->departments;

        return $jsonCollection;
    }
}