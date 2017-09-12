<?php

namespace Api\Services;

use Api\Filters\HeaderFilter;
use Api\Models\ReportModel;
use Api\Helpers\UserHelper;
use Api\Transformers\ReportTransformer;

class ReportService
{
    private $headerFilter;
    public $result = [];
    public $reportModel;
    public $userHelper;
    public $reportTransformer;
    public $quantityItems = 10;
    public $filter = [];


    /**
     * ReportService constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-21]
     * @package [Api\Services]
     * @param   HeaderFilter $headerFilter
     * @param   ReportModel $reportModel
     * @param   UserHelper $userHelper
     * @param   ReportTransformer $reportTransformer
     */
    public function __construct(
        HeaderFilter $headerFilter,
        ReportModel $reportModel,
        UserHelper $userHelper,
        ReportTransformer $reportTransformer
    )
    {
        $this->headerFilter = $headerFilter;
        $this->reportModel = $reportModel;
        $this->userHelper = $userHelper;
        $this->reportTransformer = $reportTransformer;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-21]
     * @package [Api\Services]
     * @param   Request $request
     * @return  Array
     */
    public function getReport($request)
    {

        $this->getFilter($request);
        $userId = $this->userHelper->getUserId();
        $report = $this->getReportByUserId($userId);
        return $report;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-22]
     * @package [Api\Services]
     * @param   $userId
     * @return  Array
     */
    public function getReportByUserId($userId)
    {
        $reportCollection = $this->reportModel->getReportByUserRuleId($userId, $this->filter);
        $report = $this->reportTransformer->transformReport($reportCollection);
        return $report;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-24]
     * @package [Api\Services]
     * @param   \Illuminate\Http\Request $request
     * @return  Array
     */
    public function getFilter($request)
    {
        $this->filter['quantityItems'] = ($request->has('quantityItems')) ? $request->input('quantityItems') : $this->quantityItems;
        $this->filter['ruleName'] = ($request->has('ruleName')) ? $request->input('ruleName') : '';
        $this->filter['rule'] = ($request->has('rule')) ? $request->input('rule') : '';
        $this->filter['dateStart'] = ($request->has('dateStart')) ? $this->convertDate($request->input('dateStart')) : date("Y-m-" . '01');
        $this->filter['dateEnd'] = ($request->has('dateEnd')) ? $this->convertDate($request->input('dateEnd')) : date("Y-m-d");

        return $this->filter;
    }

    /**
     * Convert date from default d/m/Y for Y-m-d
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @since   [2017-08-24]
     * @param   $date
     * @return  bool|string
     */
    public function convertDate($date)
    {
        $date = str_replace('/', '-', $date);
        return date('Y-m-d', strtotime($date));
    }
}
