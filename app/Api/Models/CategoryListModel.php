<?php

namespace Api\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CategoryListModel extends Model
{
	protected $connection = "emailpro_analitcs";

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getCategories(\Api\Helpers\UserHelper $userHelper, $idDepartment, $query, $offset, $limit) {
		$this->setTable("subcategoria_segmentador_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

    	$query = CategoryListModel::select(DB::raw('id_sub_categoria, utf8Fix(nm_sub_categoria) as nm_sub_categoria'));        
        $query->where('nm_sub_categoria', '<>', '');
        $query->whereRaw('utf8Fix(nm_sub_categoria) LIKE "'. $queryLike . '"');

        if (isset($idDepartment)) {
            $query->where('id_categoria', '=', $idDepartment);
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
    public function getCategoriesCount(\Api\Helpers\UserHelper $userHelper, $idDepartment, $query) {
		$this->setTable("subcategoria_segmentador_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

        $query = CategoryListModel::select(DB::raw('id_sub_categoria, utf8Fix(nm_sub_categoria) as nm_sub_categoria'));        
        $query->where('nm_sub_categoria', '<>', '');
        $query->whereRaw('utf8Fix(nm_sub_categoria) LIKE "'. $queryLike . '"');

        if (isset($idDepartment)) {
            $query->where('id_categoria', '=', $idDepartment);
        }

        return $query->count();
    }
}