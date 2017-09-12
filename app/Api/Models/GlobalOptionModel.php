<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalOptionModel extends Model
{
    private $result;
    protected $table = 'global_options';
    public $timestamps = false;


    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-06-28]
    * @param   int $optionId
    * @return  bool
    */
    public function validOption($optionId)
    {
    	if($optionId == null){
    		return false;
    	}
        $this->result = GlobalOptionModel::where('id','=', $optionId);
        $options = $this->result->get();
        return $options->count()==0;
    }

}