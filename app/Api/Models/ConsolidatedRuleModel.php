<?php

namespace Api\Models;

use Api\Types\PealType;
use Illuminate\Database\Eloquent\Model;

class ConsolidatedRuleModel extends Model
{
    private $result;
    protected $table = 'consolidated_rules';


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-26]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getMaxRuleOrderByUser($userHelper)
    {
        return $this->joinDefault()
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('consolidated_rules.status', '=', '1')
            ->orderBy('users_rules.order','desc')
            ->take('1')
            ->get(['users_rules.order']);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRuleVersion($userHelper,$ruleId)
    {
        return $this->joinDefault()
            ->where('users_rules.id', '=', $ruleId)
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('consolidated_rules.status', '=', '1')
            ->get(['consolidated_rules.id','consolidated_rules.version']);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRuleVersion(\Api\Helpers\UserHelper $userHelper,$ruleId)
    {
        return $this->joinDefault()
            ->where('users_rules.id', '=', $ruleId)
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->get(['consolidated_rules.*']);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-27]
     * @param   $consolidatedId
     * @param   $status
     * @return  Json
     */
    public function alterStatusRuleConsolidated($consolidatedId,$status)
    {
        return ConsolidatedRuleModel::where('id', '=', $consolidatedId)
            ->update([
                'status' => $status
            ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-28]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   $ruleId
     * @return  Json
     */
    public function inactiveRuleConsolidatedByRuleId(\Api\Helpers\UserHelper $userHelper,$ruleId)
    {
            return $this->joinDefault()
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.id', '=', $ruleId)
            ->update([
                'consolidated_rules.status' => 0
            ]);
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-26]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   int $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getDataRules($userHelper, $ruleId)
    {
        return $this->joinDefault()
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.id', '=', $ruleId)
            ->where('consolidated_rules.status', '=', '1')
            ->get([
                    'consolidated_rules.data',
                    'consolidated_rules.version',
                    'consolidated_rules.created_at'
            ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-26]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    private function joinDefault()
    {
        $this->result = ConsolidatedRuleModel::join(
            'users_rules',
            'users_rules.id',
            '=',
            'consolidated_rules.userRuleId'
        );

        return $this->result;
    }


}
