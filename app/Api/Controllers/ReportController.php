<?php

namespace Api\Controllers;

use Illuminate\Http\Request;
use Api\Helpers\UserHelper;
use Api\Services\ReportService;

class ReportController extends ApiBtgController
{
    private $userHelper;
    private $reportService;

    /**
     * ReportController constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-21]
     * @package [Api\Controllers]
     * @param   UserHelper $userHelper
     * @param   ReportService $reportService
     */
    public function __construct(
        UserHelper $userHelper,
        ReportService $reportService
    )
    {
        $this->userHelper = $userHelper;
        $this->reportService = $reportService;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-21]
     * @package [Api\Controllers]
     * @param   Request $request
     * @return  \Api\Services\Array
     */
    public function store(Request $request)
    {
        return $this->reportService->getReport($request);
    }

}
