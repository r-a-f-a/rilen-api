<?php

namespace Api\Services;

use Api\Transformers\ThemeTagTransformer;
use Api\Models\ThemeTagModel;
use Api\Filters\HeaderFilter;
use Illuminate\Http\Request;

class ThemeTagService
{
    private $themeTagTransformer;
    private $themeTagModel;
    private $headerFilter;
    public $result = [];

    public function __construct(
        ThemeTagTransformer $themeTagTransformer,
        ThemeTagModel $themeTagModel,
        HeaderFilter $headerFilter
    )
    {
        $this->themeTagTransformer = $themeTagTransformer;
        $this->themeTagModel = $themeTagModel;
        $this->headerFilter = $headerFilter;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-11]
     * @return  array
     */
    public function getThemeTagsList()
    {
        $tagsGroups = $this->getThemeTagsGroupsList();
        if (empty($tagsGroups)) {
            return $this->headerFilter->getEmptyResult();
        }
        foreach ($tagsGroups['result'] as $keyGroup => $group) {
            $this->result[$keyGroup] = $group;
            $tags = $this->getThemeTagsById($group['id']);
            $this->getTagsOptions($tags['result'], $keyGroup);
            $this->getTagType($tags['result'], $keyGroup);
        }
        $return['total'] = count($this->result);
        $return['result'] = $this->result;
        return $return;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-20]
     * @return  array
     */
    public function getTagsOptions($tags, $keyGroup)
    {
        foreach ($tags as $keyTag => $tag) {
            $options = $this->getThemeTagsOptionsById($tag['id']);
            if ($options) {
                $tag['options'] = $options['result'];
            }
            $this->result[$keyGroup]['tags'][$keyTag] = $tag;
        }
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-24]
     */
    public function getTagType($tags, $keyGroup)
    {
        foreach ($tags as $keyTag => $tag) {
            $type = $this->getThemeTagTypeById($tag['typeId']);
            $type = $type['result']['type'];
            $this->result[$keyGroup]['tags'][$keyTag]['type'] = $type;
        }
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-19]
     * @return  array
     */
    public function getThemeTagsGroupsList()
    {
        $tagsGroupsList = $this->themeTagModel->getThemeTagsGroupsList();
        return $this->themeTagTransformer->transformGroups($tagsGroupsList);
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-19]
     * @return  array
     */
    public function getThemeTagsById($groupId)
    {
        $tagsList = $this->themeTagModel->getThemeTagsById($groupId);
        return $this->themeTagTransformer->transformTags($tagsList);
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-24]
     * @return  array
     */
    public function getThemeTagTypeById($id)
    {
        $type = $this->themeTagModel->getThemeTagTypeById($id);
        return $this->themeTagTransformer->transformType($type);
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-19]
     * @return  array
     */
    public function getThemeTagsOptionsById($tagId)
    {
        $options = $this->themeTagModel->getThemeTagsOptionsById($tagId);
        return (count($options) > 0) ? $this->themeTagTransformer->transformOptions($options) : null;
    }
}
