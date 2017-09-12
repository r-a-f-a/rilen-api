<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;
use Api\Types\RuleType;
use Api\Types\TurnType;

class RuleModel extends Model
{
    private $result;
    protected $table = 'rules';

    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2016-08-21]
     * @param $ruleId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRule($ruleId)
    {
        $this->joinDefault();
        $this->result->where('rule_types.status', '=', TurnType::ON)
            ->where('rules.status', '=', TurnType::ON)
            ->where('rules.id', '=', $ruleId)
            ->orderBy('rules.id','ASC');

        return $this->result->get([
            'rules.id as ruleId',
            'rule_types.id as typeId',
            'rule_types.name as typeName',
            'rule_types.alias as typeAlias',
            'rules.name as name',
            'rules.alias as alias',
            'rules.peal as peal',
            'rules.module as module',
            'rules.description as description',
            'rules.techDescription as techDescription',
            'rules.icon as icon',
            'rules.groupId as groupId'
        ]);
    }
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-02-14]
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function isHomologation()
    {
        $this->joinDefault();
        $this->result->where('rule_types.status', '=', TurnType::ON)
            ->where('rules.status', '=', TurnType::ON)
            ->orderBy('rules.id','ASC');

        return $this->result->get([
            'rules.id as ruleId',
            'rule_types.id as typeId',
            'rule_types.name as typeName',
            'rule_types.alias as typeAlias',
            'rules.name as name',
            'rules.alias as alias',
            'rules.description as description',
            'rules.techDescription as techDescription',
            'rules.icon as icon',
            'rules.groupId as group'
        ]);
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-02-14]
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function notHomologation()
    {
        $this->joinDefault();
        $this->result->where('rule_types.status', '=', TurnType::ON)
            ->where('rules.status', '=', TurnType::ON)
            ->where('rules.ruleTypeId', '=', RuleType::AUTOMATIC)
            ->orderBy('rules.id','ASC');

            return $this->result->get([
                'rules.id as ruleId',
                'rule_types.id as typeId',
                'rule_types.name as typeName',
                'rule_types.alias as typeAlias',
                'rules.name as name',
                'rules.alias as alias',
                'rules.description as description',
                'rules.techDescription as techDescription',
                'rules.icon as icon',
                'rules.groupId as group'
            ]);
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-02-22]
    * @param   int $id
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getRuleName($id)
    {
        $this->result = RuleModel::where('id', '=', $id);
        return $this->result->get([
            'rules.name as name'
        ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @param   int $id
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getRuleGroups($id)
    {
        $this->result = RuleModel::join(
                            'rules_groups',
                            'rules.id',
                            '=',
                            'rules_groups.ruleId'
                        )
                        ->where('rules.id', '=', $id)
                        ->orderBy('rules_groups.order', 'asc');

        return $this->result->get([
            'rules_groups.groupId as groupId',
            'rules_groups.order'
        ]);
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2016-02-14]
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    private function joinDefault()
    {
        $this->result = RuleModel::join(
            'rule_types',
            'rules.ruleTypeId',
            '=',
            'rule_types.id'
        );

        $this->result->join(
            'periods',
            'rules.periodId',
            '=',
            'periods.id'
        );

        return $this->result;
    }
}
