<?php

namespace Api\Transformers;

use Api\Services\RuleService;
use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class TemplateTransformer extends HydratorAbstract
{
	public function transform(\illuminate\Support\Collection $templateCollection) 
	{
        $jsonCollection['result'] = $templateCollection[0];

        return $jsonCollection;
	}
}