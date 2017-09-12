<?php

namespace Api\Hydrators;

use League\Fractal\TransformerAbstract;

abstract class HydratorAbstract extends TransformerAbstract
{
	protected $arrayKeyConfig;
	protected $arrayBoolConfig 		 = true;
	protected $collectionTransformer = [];
	protected $collectionHydrator    = [];

	/**
	* @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
	* @package [Api\Hydrators]
	* @since   [2016-02-14]
	* @param   \illuminate\Support\Collection $getCollection
	* @return  Json
	*/
	protected function transform(\illuminate\Support\Collection $getCollection){}

	/**
	* @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
	* @package [Api\Hydrators]
	* @since   [2016-02-23]
	* @param   \illuminate\Support\Collection $getCollection
	* @param   array $multipleCollection
	* @return  Json
	*/
	protected function transformMultiple(
		\illuminate\Support\Collection $getCollection,
		$multipleCollection
	){}
}
