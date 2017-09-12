<?php

namespace Api\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DepartmentListModel extends Model
{
	protected $connection = "emailpro_analitcs";

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getDepartments(\Api\Helpers\UserHelper $userHelper, $query, $offset, $limit) {
		$this->setTable("categoria_segmentador_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

    	return DepartmentListModel::select(DB::raw('id_categoria, utf8Fix(nm_categoria) as nm_categoria'))
            ->where("nm_categoria", "<>", "")
    		->whereRaw('utf8Fix(nm_categoria) LIKE "'. $queryLike . '"')
    		->skip($offset)
    		->take($limit)
            ->orderBy("id_categoria", "ASC")
    		->get();
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getCountDepartments(\Api\Helpers\UserHelper $userHelper, $query) {
        $this->setTable("categoria_segmentador_" . $userHelper->getUserIdAlliN());

        $queryLike = '%' . $query . '%';

        return DepartmentListModel::select(DB::raw('id_categoria, utf8Fix(nm_categoria) as nm_categoria'))
            ->where("nm_categoria", "<>", "")
            ->whereRaw('utf8Fix(nm_categoria) LIKE "'. $queryLike . '"')
            ->count();
    }
}