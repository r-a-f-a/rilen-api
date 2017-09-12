<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
	protected $table = 'templates';

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
	public function getTemplates(\Api\Helpers\UserHelper $userHelper) 
	{
		return TemplateModel::where('templates.userId', '=', $userHelper->getUserId())
			->get([
	        	"templates.id", 
	        	"templates.name", 
	        	"templates.html",
	        ]);
	}

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
	public function getTemplateById(\Api\Helpers\UserHelper $userHelper, $id) 
	{
		return TemplateModel::where('templates.id', '=', $id)
			->orWhere('templates.userId', '=', "0")
			->where('templates.userId', '=', $userHelper->getUserId())
			->get([
	        	"templates.id", 
	        	"templates.name", 
	        	"templates.html"
	        ]);
	}

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
	public function updateTemplate(\Api\Helpers\UserHelper $userHelper, $parameters) 
	{
		return TemplateModel::where('id', '=', $parameters['id'])
            ->where('userId', '=', $userHelper->getUserId())
            ->update([
                'name' => $parameters['name'], 
                'html' => $parameters['html']
            ]);
	}

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
	public function deleteTemplate(\Api\Helpers\UserHelper $userHelper, $id) 
	{
		return TemplateModel::where('templates.userId', '=', $userHelper->getUserId())
			->where('templates.id', '=', $id)
			->delete();
	}

	/**
	 * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
	 * @package [Api\Models]
	 * @since   [2017-07-06]
	 * @return  Json
	 */
	public function getAllTemplates(\Api\Helpers\UserHelper $userHelper)
	{
		return TemplateModel::where('templates.userId', '=', $userHelper->getUserId())
			->orWhere('templates.userId', '=', "0")
			->get([
				"templates.id",
				"templates.name",
				"templates.html",
			]);
	}
}
