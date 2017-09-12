<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;
use Api\Types\PealType;

class OptionsFieldModel extends Model
{
    private $result;
    protected $table = 'sources';

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @param   int $sourceId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getTableSourceId($sourceId)
    {
        $this->setConnection('mysql');
        $this->setTable('sources');
        return OptionsFieldModel::where('id','=',$sourceId)->get(['tableSourceId']);
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @param   int $sourceId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getConfigTableSource($sourceId)
    {
        $this->result = OptionsFieldModel::join(
            'table_source',
            'sources.tableSourceId',
            '=',
            'table_source.id'
        );
        $this->result->join('connections','table_source.connection','=','connections.id')
        ->where('sources.id', '=', $sourceId);

        return $this->result->get([
            'connections.name as connection',
            'table_source.table as table',
            'table_source.aliasField as aliasField',
            'table_source.valueField as valueField',
            'table_source.where as where',
            'table_source.order as order',
            'table_source.limit as limit'
        ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @param   array $tableSource
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getOptionsTableSource($tableSource)
    {
        $this->setConnection($tableSource['connection']);
        $this->setTable($tableSource['table']);

        return OptionsFieldModel::whereRaw(
            $tableSource['where']
        )->take($tableSource['limit'])
         ->orderBy($tableSource['valueField'],$tableSource['order'])
         ->get([
                $tableSource['aliasField'].' as alias',
                $tableSource['valueField'].' as value'
           ]);
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-22]
     * @param   int $sourceId
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getOptionsSources($sourceId)
    {
        $this->result = OptionsFieldModel::join(
            'options_source',
            'sources.id',
            '=',
            'options_source.sourceId'
        );
        $this->result->where('sources.id', '=', $sourceId)
                     ->where('options_source.status','=','1');

        return $this->result->get([
            'options_source.name as alias',
            'options_source.value as value'
        ]);
    }


}
