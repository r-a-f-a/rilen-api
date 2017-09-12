<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends ApiBtgController
{
    private $userHelper;
    private $dashboardService;

    /**
     * DashboardController constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2016-08-28]
     * @param   UserHelper $userHelper
     * @param   DashboardService $dashboardService
     */
    public function __construct(
        UserHelper $userHelper,
        DashboardService $dashboardService
    )
    {
        $this->userHelper  = $userHelper;
        $this->dashboardService = $dashboardService;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2016-08-28]
     * @return  array
     */
    public function index() {
        return $this->dashboardService->getInfos();
    }
}
