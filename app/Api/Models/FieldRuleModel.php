<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class FieldRuleModel extends Model
{
    private $result;
    protected $table = 'objects';

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @param   int $groupsId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getObjectsGroups($groupsId)
    {
        $this->joinDefault();
        $this->result->whereIn('groups_objects.groupsId', $groupsId)
            ->orderBy('rules_groups.order', 'asc')
            ->orderBy('groups_objects.order', 'asc')
            ->groupBy('objects.id')
            ->groupBy('groups_objects.groupsId');

        return $this->result->get([
            'objects.sourceId as sourceId',
            'objects.id as objectId',
            'objects.name as name',
            'objects.title as title',
            'types.name as type',
            'objects.placeholder as placeholder',
            'objects.mask as mask',
            'objects.help as help',
            'objects.required as required',
            'groups_objects.order'
        ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    private function joinDefault()
    {
        $this->result = FieldRuleModel::join(
            'types',
            'types.id',
            '=',
            'objects.typeId'
        );
        $this->result->join(
            'groups_objects',
            'groups_objects.objectId',
            '=',
            'objects.id'
        );

        $this->result->join(
            'rules_groups',
            'rules_groups.groupId',
            '=',
            'groups_objects.groupsId'
        );
        return $this->result;
    }
}
