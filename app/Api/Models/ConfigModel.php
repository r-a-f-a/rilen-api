<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    private $result;
    protected $table = 'configs';
    public $timestamps = false;


    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   int $userid
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function configById($userid)
    {
        $this->result = ConfigModel::where('userId', '=', $userid)->first();
        return $this->result;
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   int $userid
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function showConfig($userid)
    {
        $this->result = ConfigModel::where('userId', '=', $userid);
        return $this->result->get();
    }

    public function updateVmta($vmta, $userId)
    {
        return ConfigModel::where('userId', '=', $userId)
            ->update(['vmta' => $vmta]);
    }

}