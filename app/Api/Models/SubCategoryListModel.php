<?php

namespace Api\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SubCategoryListModel extends Model
{
	protected $connection = "emailpro_analitcs";

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getSubCategories(\Api\Helpers\UserHelper $userHelper, $idCategory, $query, $offset, $limit) {
		$this->setTable("sub_sub_categoria_segmentador_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

    	$query = SubCategoryListModel::select(DB::raw('id_ss_categoria, utf8Fix(nm_ss_categoria) as nm_ss_categoria'));        
        $query->where('nm_ss_categoria', '<>', '');
        $query->whereRaw('utf8Fix(nm_ss_categoria) LIKE "'. $queryLike . '"');

        if (isset($idCategory)) {
            $query->where('id_sub_categoria', '=', $idCategory);
        }

        $query->skip($offset);
        $query->take($limit);

        return $query->get();
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Int
     */
    public function getSubCategoriesCount(\Api\Helpers\UserHelper $userHelper, $idCategory, $query) {
		$this->setTable("sub_sub_categoria_segmentador_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

        $query = SubCategoryListModel::select(DB::raw('id_ss_categoria, utf8Fix(nm_ss_categoria) as nm_ss_categoria'));        
        $query->where('nm_ss_categoria', '<>', '');
        $query->whereRaw('utf8Fix(nm_ss_categoria) LIKE "'. $queryLike . '"');

        if (isset($idCategory)) {
            $query->where('id_sub_categoria', '=', $idCategory);
        }

        return $query->count();
    }
}