<?php

namespace Api\Services;

use Api\Transformers\ThemeTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\ThemeModel;
use Illuminate\Http\Request;

class ThemeService
{
    private $themeModel;

    public function __construct(
        ThemeTransformer $themeTransformer,
        ThemeModel $themeModel,
        HeaderFilter $headerFilter
    ) {
        $this->themeTransformer = $themeTransformer;
        $this->headerFilter     = $headerFilter;
        $this->themeModel       = $themeModel;
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $themeId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getThemeById(\Api\Helpers\UserHelper $userHelper, $themeId)
    {

        $themeListById = $this->themeModel->getThemeById($userHelper, $themeId);

        if ($themeListById->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->themeTransformer->transform($themeListById);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getThemeList(\Api\Helpers\UserHelper $userHelper)
    {

        $themeListById = $this->themeModel->getThemeList($userHelper);
        if ($themeListById->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->themeTransformer->transform($themeListById, true);
    }


    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-11]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeListAll(\Api\Helpers\UserHelper $userHelper)
    {

        $themeListById = $this->themeModel->getThemeListAll($userHelper);
        if ($themeListById->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->themeTransformer->transform($themeListById, true);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper, Illuminate\Http\Request $request
    * @return  json
    */
    public function createTheme(\Api\Helpers\UserHelper $userHelper, Request $request)
    {
        if($request->has('id')){
            $theme = ThemeModel::find($request->input("id"));
            $theme->userId   = $theme->userId;
            $theme->name     = ($request->has("name"))? $request->input("name") : $theme->name;
            $theme->configs  = ($request->has("configs"))? $request->input("configs") : $theme->configs;
            $theme->start_at = ($request->has("startAt"))? $request->input("startAt") : $theme->start_at;
            $theme->end_at   = ($request->has("endAt"))? $request->input("endAt") : $theme->end_at;
            $theme->default  = ($request->has("default"))? $request->input("default") : $theme->default;
            $theme->status   = ($request->has("status"))? $request->input("status") : $theme->status;
        }else{
            $theme = new ThemeModel();
            $theme->userId   = $userHelper->getUserId();
            $theme->name     = $request->input("name");
            $theme->configs  = $request->input("configs");
            $theme->start_at = $request->input("startAt");
            $theme->end_at   = $request->input("endAt");
            $theme->default  = $request->input("default");
            $theme->status   = $request->input("status");
        }

        $json["status"] = $theme->save() > 0;
        return $json;

    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper, $themeId
    * @return  json
    */
    public function destroyTheme(\Api\Helpers\UserHelper $userHelper, $themeId)
    {
        $json["status"] = $this->themeModel->deleteThema($userHelper->getUserId(), $themeId)>0;
        return $json;
    }
}
