<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalUserModel extends Model
{
    private $result;
    protected $table = 'global_user';
    public $timestamps = false;
    protected $fillable = ['id', 'userId', 'globalId', 'value'];

     /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-06-27]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getConfigGlobalsOptionsList(\Api\Helpers\UserHelper $userHelper)
    {
        $this->result = GlobalUserModel::join(
            'global',
            'global.id',
            '=',
            'global_user.globalId'
        )->where('userId', '=', $userHelper->getUserId())->select("global_user.id","global.name","global_user.value");

        return $this->result->get();
    }

    public static function insertUpdate(array $attributes = [])
    {
        $model = new static($attributes);

        $model->fill($attributes);

        if ($model->usesTimestamps()) {
            $model->updateTimestamps();
        }

        $attributes = $model->getAttributes();

        $query = $model->newBaseQueryBuilder();
        $processor = $query->getProcessor();
        $grammar = $query->getGrammar();

        $table = $grammar->wrapTable($model->getTable());
        $keyName = $model->getKeyName();
        $columns = $grammar->columnize(array_keys($attributes));
        $insertValues = $grammar->parameterize($attributes);

        $updateValues = [];

        if ($model->primaryKey !== null) {
            $updateValues[] = "{$grammar->wrap($keyName)} = LAST_INSERT_ID({$keyName})";
        }

        foreach ($attributes as $k => $v) {
            $updateValues[] = sprintf("%s = '%s'", $grammar->wrap($k), $v);
        }

        $updateValues = join(',', $updateValues);

        $sql = "insert into {$table} ({$columns}) values ({$insertValues}) on duplicate key update {$updateValues}";
        $id = $processor->processInsertGetId($query, $sql, array_values($attributes));

        $model->setAttribute($keyName, $id);

        return $model;

    }

}