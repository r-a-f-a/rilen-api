<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class TemplateListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @return  Json
     */
	public function transform(\illuminate\Support\Collection $templateCollection) 
	{
        $templateCollection->transform(
            function ($template) {
                $this->templates[$template->id] = [
                    'id' => $template->id,
                    'name' => $template->name,
                    'html' => $template->html
                ];
            }
        );

        $jsonCollection['count'] = $templateCollection->count();
        $jsonCollection['result'] = $this->templates;

        return $jsonCollection;
	}
}