<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ThemeService;
use Illuminate\Support\Facades\View;
use TwigBridge\Facade\Twig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemesController extends ApiBtgController
{
	private $userHelper;
    private $themeService;

     public function __construct(ThemeService $themeService, UserHelper $userHelper)
    {
        $this->themeService = $themeService;
        $this->userHelper  = $userHelper;
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-06-22]
    * @return  Json
    */
    public function show($themeId)
    {
    	return $this->themeService->getThemeById($this->userHelper, $themeId);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-06-22]
    * @return  Json
    */
    public function index()
    {
    	return $this->themeService->getThemeList($this->userHelper);
    }
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper, Illuminate\Http\Request $request
    * @return  json
    */
    public function store(Request $request)
    {
    	return $this->themeService->createTheme($this->userHelper, $request);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-22]
    * @param   \Api\Helpers\UserHelper $userHelper, $themeId
    * @return  json
    */
    public function destroy($themeId)
    {
    	return $this->themeService->destroyTheme($this->userHelper, $themeId);
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-07-11]
     * @return  Json
     */
    public function all()
    {
        return $this->themeService->getThemeListAll($this->userHelper);
    }

}