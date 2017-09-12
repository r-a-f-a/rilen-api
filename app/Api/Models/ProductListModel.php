<?php

namespace Api\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ProductListModel extends Model
{
	protected $connection = "emailpro_analitcs";

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @return  Json
     */
    public function getProducts(\Api\Helpers\UserHelper $userHelper, $query, $offset, $limit, $html) {
		$this->setTable("xml_" . $userHelper->getUserIdAlliN());

		$queryLike = '%' . $query . '%';

        $select = 'id_produto, utf8Fix(nome_produto) as nome_produto, imagem';

        if ($html) {
            $select = $select . ', preco as price, preco_por as priceFrom, link_produto as link';
        }

    	$result = ProductListModel::select(DB::raw($select))
            ->where('id_produto', '=', $query)
            ->orWhereRaw('(utf8Fix(nome_produto) LIKE "'. $queryLike . '" OR utf8Fix(descricao_produto) LIKE "'. $queryLike .'")')
            ->skip($offset)
            ->take($limit);

        if ($html) {
            $result->orderByRaw("RAND()");
        }
        return $result->get();
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @return  Json
     */
    public function getCountProducts(\Api\Helpers\UserHelper $userHelper, $query) {
        $this->setTable("xml_" . $userHelper->getUserIdAlliN());

        $queryLike = '%' . $query . '%';

        return ProductListModel::where('id_produto', '=', $query)
            ->orWhereRaw('(utf8Fix(nome_produto) LIKE "'. $queryLike . '" OR utf8Fix(descricao_produto) LIKE "'. $queryLike .'")')
            ->count();
    }



    /**
     * @return mixed
     */
    public function getRandProducts(\Api\Helpers\UserHelper $userHelper, $limit = 10)
    {
        $this->setTable("xml_" . $userHelper->getUserIdAlliN());
        return ProductListModel::take($limit)->orderByRaw("RAND()")->get();
    }
}