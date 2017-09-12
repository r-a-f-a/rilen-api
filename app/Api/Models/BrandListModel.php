<?php

namespace Api\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BrandListModel extends Model
{
	protected $connection = "emailpro_analitcs";

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getBrands(\Api\Helpers\UserHelper $userHelper, $query, $offset, $limit) {
		$this->setTable("marca_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

    	return BrandListModel::select(DB::raw('id, utf8Fix(marca) as marca'))
            ->whereRaw('utf8Fix(marca) LIKE "'. $queryLike . '"')
			->skip($offset)
    		->take($limit)
    		->get();
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Int
     */
    public function getBrandsCount(\Api\Helpers\UserHelper $userHelper, $query) {
		$this->setTable("marca_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

    	return BrandListModel::select(DB::raw('id, utf8Fix(marca) as marca'))
            ->whereRaw('utf8Fix(marca) LIKE "'. $queryLike . '"')
            ->count();
    }
}