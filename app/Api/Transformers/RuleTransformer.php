<?php

namespace Api\Transformers;

use Api\Services\RuleService;
use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;
use Api\Models\UserRuleModel;

class RuleTransformer extends HydratorAbstract
{
	private $userRuleModel;
	private $categories;
	public function __construct()
	{
		$this->userRuleModel = new UserRuleModel();
	}

	/**
	* @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
	* @package [Api\Transformers]
	* @since   [2016-02-15]
	* @param   \illuminate\Support\Collection $ruleCollection
	* @todo    Refactor pending
	* @return  Json
	*/
	public function transform(\illuminate\Support\Collection $ruleCollection)
	{
		$categories = [];
		$ruleCollection->transform(
			function ($collection) {
				$this->collectionHydrator[] = [
					'ruleId'	   => $collection->ruleId,
					'typeId'       => $collection->typeId,
					'nameCategory' => $collection->typeName,
					'nameRule' 	   => $collection->name,
					'description' 	   => $collection->description,
					'tech' 	   => $collection->techDescription,
					'alias'		   => $collection->alias,
					'icon' 		   => $collection->icon,
				];
				$category = $collection->typeName;
				$this->categories[$category] = $collection->typeAlias;
			}
		);

		foreach ($this->collectionHydrator as $key => $collection) {
			$this->arrayKeyConfig = $collection['typeId'];


			$rulesActive = $this->userRuleModel->getPealByRuleId(
				new UserHelper(), $collection['ruleId'])->count();

			$rulesActiveStatus = false;

			if($rulesActive > 0) {
				$rulesActiveStatus = true;
			}

			$transform = [
				'id'  	 => $collection['ruleId'],
				'name'   => $collection['nameRule'],
				'alias'  => $collection['alias'],
				'category'=> $collection['nameCategory'],
				'icon'   => $collection['icon'],
				'tech'   => $collection['tech'],
				'description'   => $collection['description'],
				'active' => $rulesActiveStatus
			];

			$this->collectionTransformer[] = $transform;
		}

		$jsonCollection['count'] = $ruleCollection->count();
		$jsonCollection['groups'] = $this->categories;
		$jsonCollection['rules'] = $this->collectionTransformer;


		return $jsonCollection;
	}

	/**
	* @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
	* @package [Api\Transformers]
	* @since   [2016-02-15]
	* @param   \illuminate\Support\Collection $ruleCollection
	* @todo    Refactor pending
	* @return  Json
	*/
	public function transformRule(\illuminate\Support\Collection $ruleCollection)
	{
		$ruleCollection->transform(
			function ($collection) {
				$this->collectionHydrator = [
					'ruleId'	   => $collection->ruleId,
					'typeId'       => $collection->typeId,
					'nameCategory' => $collection->typeName,
					'nameRule' 	   => $collection->name,
					'alias'		   => $collection->alias,
					'peal'		   => $collection->peal,
					'module'		   => $collection->module,
					'icon' 		   => $collection->icon,
					'tech'   => $collection['techDescription'],
					'description'   => $collection['description'],
					'group' 		   => $collection->groupId
				];
			}
		);
		$jsonCollection['rule'] = $this->collectionHydrator;
		return $jsonCollection;
	}
}
