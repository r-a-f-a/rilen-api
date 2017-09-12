<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalModel extends Model
{
    private $result;
    protected $table = 'global';
    public $timestamps = false;

    
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-06-27]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getConfigGlobalsList()
    {
        $this->result = GlobalModel::join(
            'types',
            'types.id',
            '=',
            'global.typeId'
        )->select("global.id","global.name","global.title","types.id as typeID","types.name as type","types.options" );

        return $this->result->get();
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-06-27]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getOptions($globalsId)
    {
        $this->result = GlobalModel::join(
            'global_options',
            'global_options.globalsId',
            '=',
            'global.Id'
        )->select("global_options.id","global_options.alias","global_options.value");

        return $this->result->get();
    }

    public function getConfig($name) {
        $this->result = GlobalModel::join(
            'types',
            'types.id',
            '=',
            'global.typeId'
        )->select("global.id","global.name","global.title","types.id as typeID","types.name as type","types.options" )
        ->where("global.name",'=',$name);

        return $this->result->get();
    }
    
}