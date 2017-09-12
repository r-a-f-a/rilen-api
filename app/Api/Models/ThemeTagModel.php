<?php

namespace Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ThemeTagModel extends Model
{
    private $result;
    protected $table = 'tags';

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-18]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagsGroupsList()
    {
        $this->result = DB::table('tags_groups')
            ->where('status', '=', 1)
            ->orderBy('order');

        return collect($this->result->get());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-17]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagsList()
    {

        $this->result = ThemeTagModel::where('tags.status', '=', 1)
            ->orderBy('tags.order');

        return $this->result->get();
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-18]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagsById($groupId)
    {
        $this->result = ThemeTagModel::where('tags.status', '=', 1)
            ->where('tags.tagsGroupId', '=', $groupId)
            ->orderBy('tags.order');

        return collect($this->result->get());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-18]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagsOptionsById($tagId)
    {

        $this->result = DB::table('tags_options')
        ->where('tagId', '=', $tagId);

        return collect($this->result->get());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-18]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagTypeById($id)
    {
        $this->result = DB::table('types')
            ->where('types.id', '=', $id);
        return collect($this->result->get());
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-07-18]
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getThemeTagsOptionsList()
    {
        $this->result = DB::table('tags_options');
        return collect($this->result->get());
    }
}
