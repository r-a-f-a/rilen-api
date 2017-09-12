<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ThemeTagService;


class ThemesTagsController extends ApiBtgController
{
    private $userHelper;
    private $themeTagService;

    public function __construct(ThemeTagService $themeTagService, UserHelper $userHelper)
    {
        $this->themeTagService = $themeTagService;
        $this->userHelper  = $userHelper;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-07-17]
     * @return  array
     */
    public function index()
    {
        return $this->themeTagService->getThemeTagsList();
    }
}