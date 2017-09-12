<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class PealModel extends Model
{
    private $result;

    protected $table = 'users_rules';

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $pealId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getPealById(\Api\Helpers\UserHelper $userHelper, $pealId)
    {
        $this->result = PealModel::join(
            'rules',
            'rules.id',
            '=',
            'users_rules.ruleId'
        );
        $this->result->where('users_rules.userId', '=', $userHelper->getUserId())
            ->where('users_rules.pealFrom', '=', $pealId);

        return $this->result->get([
            'users_rules.id',
            'rules.name',
            'users_rules.status',
            'rules.icon as icon'
        ]);
    }
}
