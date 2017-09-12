<?php

namespace Api\Services;

use Api\Transformers\PealTransformer;
use Api\Filters\HeaderFilter;
use App\Api\Models\PealModel;

class PealService
{
    private $pealModel;

    public function __construct(
        PealTransformer $pealTransformer,
        PealModel $pealModel,
        HeaderFilter $headerFilter
    ) {
        $this->pealTransformer = $pealTransformer;
        $this->headerFilter    = $headerFilter;
        $this->pealModel       = $pealModel;
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $pealId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getPealById(\Api\Helpers\UserHelper $userHelper, $pealId)
    {
        $pealListById = $this->pealModel->getPealById($userHelper, $pealId);

        if ($pealListById->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->pealTransformer->transform($pealListById);
    }

}
