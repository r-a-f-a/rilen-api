<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    protected $table = 'consolidated_sends';
    public $timestamps = false;
    private $result;

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-08-21]
     * @param   $userId
     * @return  mixed
     */
    public function getReportByUserRuleId($userId, $filter)
    {
        $this->result = $this->where('consolidated_sends.userId', '=', $userId)
            ->where('consolidated_sends.sendDate', '>=', $filter['dateStart'])
            ->where('consolidated_sends.sendDate', '<=', $filter['dateEnd'])
            ->groupBy('consolidated_sends.sendDate')
            ->groupBy('consolidated_sends.sendHour')
            ->groupBy('consolidated_sends.userRuleId')
            ->orderBy('consolidated_sends.sendDate', 'desc')
            ->orderBy('consolidated_sends.sendHour', 'desc')
            ->selectRaw('
                consolidated_sends.userRuleId,
                consolidated_sends.sendDate,
                consolidated_sends.sendHour,
                count(consolidated_sends.sendId) as sends,
                sum(consolidated_sends.totalClick) as sumClick,
                count(consolidated_sends.openingAt) as openings,
                consolidated_sends.rule,
                consolidated_sends.ruleName
            ');

        if (!empty($filter['ruleName'])) {
            $this->result->where('consolidated_sends.ruleName', 'like', '%' . $filter['ruleName'] . '%');
        }

        if (!empty($filter['rule'])) {
            $this->result->where('consolidated_sends.rule', 'like', '%' . $filter['rule'] . '%');
        }

        return $this->result->paginate($filter['quantityItems']);
    }


    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-08-28]
     * @param   $userId
     * @return  int
     */
    public function getTotalSendsMonth($userId)
    {
        $total = ReportModel::where('userId', '=', $userId)
            ->where('sendDate', '>=', date('Y-m-' . '01'))
            ->where('sendDate', '<=', date('Y-m-t'));

        return $total->get()->count();
    }
}
