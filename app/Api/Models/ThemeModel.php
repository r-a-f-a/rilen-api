<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeModel extends Model
{
    private $result;
    protected $table = 'themes';
    public $timestamps = false;
    
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @param   int $themeId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getThemeById(\Api\Helpers\UserHelper $userHelper, $themeId)
    {
        $this->result = ThemeModel::where('id', '=', $themeId)
                                    ->orWhere('userId', '=', "0")
                                    ->where('userId', '=', $userHelper->getUserId());

        return $this->result->get();
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function getThemeList(\Api\Helpers\UserHelper $userHelper)
    {
        $this->result = ThemeModel::where('userId', '=', $userHelper->getUserId());

        return $this->result->get();
    }


    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-11]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeListAll(\Api\Helpers\UserHelper $userHelper)
    {
        $this->result = ThemeModel::where('userId', '=', $userHelper->getUserId())
            ->orwhere('userId','=',0);

        return $this->result->get();
    }

     /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/eloquent]
    * @package [Api\Models]
    * @since   [2017-03-02]
    * @param   \Api\Helpers\UserHelper $userHelper ,$themeId
    * @return  \Illuminate\Database\Eloquent\Collection
    */
    public function deleteThema($userId, $themeId)
    {
       return ThemeModel::where('userId', '=', $userId)
                                  ->where('Id','=',$themeId)
                                  ->delete();
       
    }
}
