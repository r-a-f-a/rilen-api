<?php

namespace Api\Services;

use Api\Filters\HeaderFilter;
use Api\Models\ReportModel;
use Api\Models\UserRuleModel;
use Api\Helpers\UserHelper;

class DashboardService
{
    private $headerFilter;
    private $reportModel;
    private $userHelper;
    private $userRuleModel;

    /**
     * DashboardService constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @param   HeaderFilter $headerFilter
     * @param   ReportModel $reportModel
     * @param   UserHelper $userHelper
     * @param   UserRuleModel $userRuleModel
     */
    public function __construct(
        HeaderFilter $headerFilter,
        ReportModel $reportModel,
        UserHelper $userHelper,
        UserRuleModel $userRuleModel
    )
    {
        $this->headerFilter = $headerFilter;
        $this->reportModel = $reportModel;
        $this->userHelper = $userHelper;
        $this->userRuleModel = $userRuleModel;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @return  array
     */
    public function getInfos()
    {
        $result = [];
        $result['result']['totalSendsMonth'] = $this->getTotalSendsMonth();
        $result['result']['totalRulesActive'] = $this->getTotalRulesActive();
        $result['result']['totalRulesInactive'] = $this->getTotalRulesInactive();
        $result['result']['lastSends'] = $this->getLastSends();

        return $result;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @return  int
     */
    public function getTotalSendsMonth()
    {
        return $this->reportModel->getTotalSendsMonth($this->userHelper->getUserId());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @return  int
     */
    public function getTotalRulesActive()
    {
        return $this->userRuleModel->getTotalRulesActive($this->userHelper->getUserId());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @return  int
     */
    public function getTotalRulesInactive()
    {
        return $this->userRuleModel->getTotalRulesInactive($this->userHelper->getUserId());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2016-08-28]
     * @return  array
     */
    public function getLastSends()
    {
        $filter = [
            'dateStart' => date('Y-m-' . '01'),
            'dateEnd' => date('Y-m-t'),
            'quantityItems' => 10
        ];

        $lastSends = $this->reportModel->getReportByUserRuleId($this->userHelper->getUserId(), $filter);

        return $lastSends->toArray()['data'];
    }

}
