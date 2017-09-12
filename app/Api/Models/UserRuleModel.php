<?php

namespace Api\Models;

use Api\Types\PealType;
use Illuminate\Database\Eloquent\Model;

class UserRuleModel extends Model
{
    private $result;
    protected $table = 'users_rules';

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-02-23]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $ruleId
    * @param   int $peal
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getConsolidatedRulesNotPeal($userHelper, $ruleId, $peal)
    {
        $this->joinDefault();
        $this->result->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('rules.id', '=', $ruleId)
            ->where('consolidated_rules.status', '=', 1)
            ->where('users_rules.isDeleted','=',0)
            ->where('users_rules.pealFrom', '=', 0);

        return $this->fieldDefault();
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $ruleId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getConsolidatedRulesPeal($userHelper, $ruleId)
    {
        $this->joinDefault();
        $this->result->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.pealFrom', '=', $ruleId)
            ->where('consolidated_rules.status', '=', 1)
            ->where('users_rules.isDeleted','=',0);

        return $this->fieldDefault();
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $ruleId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getPealByRuleId($userHelper, $ruleId)
    {
        $this->joinDefault();
        $this->result->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.ruleId', '=', $ruleId)
            ->where('users_rules.pealFrom', '=', $ruleId);

        return $this->fieldDefault();
    }

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
        return UserRuleModel::join(
            'consolidated_rules',
            'consolidated_rules.userRuleId',
            '=',
            'users_rules.id')
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('consolidated_rules.status', '=', '1')
            ->orderBy('users_rules.priority','desc')
            ->take('1')
            ->get(['users_rules.priority']);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper $ruleId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getRuleVersion($userHelper,$ruleId)
    {
        return userRuleModel::join(
            'consolidated_rules',
            'consolidated_rules.userRuleId',
            '=',
            'users_rules.id')
            ->where('users_rules.id', '=', $ruleId)
            ->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('consolidated_rules.status', '=', '1')
            ->get(['consolidated_rules.id','consolidated_rules.version']);
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
        $this->joinDefault();
        $this->result->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.id', '=', $ruleId)
            ->where('consolidated_rules.status', '=', '1');

        return $this->result->get([
            'consolidated_rules.data',
            'consolidated_rules.version',
            'consolidated_rules.created_at']);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-29]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   $status
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRuleActive($userHelper,$status)
    {
        $this->result =  $this->joinDefault()
                ->where('users_rules.userId','=',$userHelper->getUserId())
                ->where('users_rules.pealFrom','=',0);

        if(!is_null($status)){
            $this->result->where('users_rules.status','=',$status);
        }

        return $this->result->get([
            'users_rules.ruleId',
            'rules.name',
            'rules.alias',
            'users_rules.order',
            'users_rules.status',
            'consolidated_rules.data',
            'consolidated_rules.version'
        ]);
    }

    /**
     * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2016-03-02]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    private function fieldDefault()
    {
        return $this->result->get([
            'users_rules.id',
            'rules.name',
            'rules.peal',
            'users_rules.status',
            'consolidated_rules.data',
            'consolidated_rules.version'
        ]);
    }

    /**
     * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2016-03-02]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    private function joinDefault()
    {
        $this->result = UserRuleModel::join(
            'rules',
            'rules.id',
            '=',
            'users_rules.ruleId'
        );

        $this->result->join(
            'consolidated_rules',
            'consolidated_rules.userRuleId',
            '=',
            'users_rules.id'
        );

        return $this->result;
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function updatePriority(\Api\Helpers\UserHelper $userHelper, $rule) 
    {
        $this->timestamps = false;

        return UserRuleModel::where('id', '=', $rule['id'])
            ->where('userId', '=', $userHelper->getUserId())
            ->update([
                'priority' => $rule['priority']
            ]);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function getPriorities(\Api\Helpers\UserHelper $userHelper) {
        return $this->joinDefault()
                    ->where('users_rules.userId', '=', $userHelper->getUserId())
                    ->where('consolidated_rules.status', '=', 1)
                    ->where('users_rules.pealFrom', '=', 0)
                    ->orderBy('users_rules.priority')
                    ->get([
                        'users_rules.id',
                        'rules.name',
                        'users_rules.priority',
                        'consolidated_rules.data'
                    ]);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Boolean
     */
    public function existUserRule(\Api\Helpers\UserHelper $userHelper, $id) {
        return UserRuleModel::where('id', '=', $id)
            ->where('userId', '=', $userHelper->getUserId())->count() > 0;
    }



    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function deleteRule(\Api\Helpers\UserHelper $userHelper, $ruleId)
    {

        return UserRuleModel::where('id', '=', $ruleId)
            ->where('userId', '=', $userHelper->getUserId())
            ->update([
                'isDeleted' => 1
            ]);
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-08-28]
     * @param   $userId
     * @return  int
     */
    public function getTotalRulesActive($userId)
    {
        $total = UserRuleModel::where('userId', '=', $userId)
            ->where('status', '=', 1)
            ->where('isDeleted', '=', 0)
            ->where('pealFrom', '=', 0);

        return $total->get()->count();
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Models]
     * @since   [2017-08-28]
     * @param   $userId
     * @return  int
     */
    public function getTotalRulesInactive($userId)
    {
        $total = UserRuleModel::where('userId', '=', $userId)
            ->where('status', '=', 0)
            ->where('isDeleted', '=', 0)
            ->where('pealFrom', '=', 0);

        return $total->get()->count();
    }
}
