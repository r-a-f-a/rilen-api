<?php

namespace Api\Transformers;

use Api\Types\TurnType;
use Api\Models\ThemeModel;
use Api\Hydrators\HydratorAbstract;

class ThemeTagTransformer extends HydratorAbstract
{
    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-07-17]
     * @param   \illuminate\Support\Collection $themeCollection, bool $list
     * @todo    Refactor pending
     * @return  Json
     */
    public function transformGroups(\illuminate\Support\Collection $themeTagCollection)
    {
        unset($this->collectionHydrator);

        $themeTagCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'name'     => $collection->name,
                    'order'     => $collection->order,
                    'status'    => $collection->status
                ];
            }
        );

        $jsonCollection['count'] = $themeTagCollection->count();
        $jsonCollection['result'] = $this->collectionHydrator;

        return $jsonCollection;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-07-17]
     * @param   \illuminate\Support\Collection $themeCollection, bool $list
     * @todo    Refactor pending
     * @return  Json
     */
    public function transformTags(\illuminate\Support\Collection $themeTagGroupCollection)
    {
        unset($this->collectionHydrator);

        $themeTagGroupCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'                => $collection->id,
                    'tagsGroupId'       => $collection->tagsGroupId,
                    'typeId'            => $collection->typeId,
                    'name'              => $collection->name,
                    'title'             => $collection->title,
                    'defaultValue'      => $collection->defaultValue,
                    'min'               => $collection->minValue,
                    'max'               => $collection->maxValue,
                    'step'              => $collection->step,
                    'order'             => $collection->order,
                    'status'            => $collection->status
                ];
            }
        );

        $jsonCollection['count'] = $themeTagGroupCollection->count();
        $jsonCollection['result'] = $this->collectionHydrator;

        return $jsonCollection;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-07-17]
     * @param   \illuminate\Support\Collection $themeCollection, bool $list
     * @todo    Refactor pending
     * @return  Json
     */
    public function transformOptions(\illuminate\Support\Collection $themeTagGroupCollection)
    {
        unset($this->collectionHydrator);

        $themeTagGroupCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'id'        => $collection->id,
                    'tagId'     => $collection->tagId,
                    'alias'     => $collection->alias,
                    'value'     => $collection->value
                ];
            }
        );

        $jsonCollection['count'] = $themeTagGroupCollection->count();
        $jsonCollection['result'] = $this->collectionHydrator;

        return $jsonCollection;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-07-24]
     * @param   \illuminate\Support\Collection $themeCollection, bool $list
     * @todo    Refactor pending
     * @return  Json
     */
    public function transformType(\illuminate\Support\Collection $themeTagTypeCollection)
    {
        unset($this->collectionHydrator);

        $themeTagTypeCollection->transform(
            function ($collection) {
                $this->collectionHydrator = [
                    'id'        => $collection->id,
                    'type'      => $collection->name,
                    'format'    => $collection->format,
                    'option'    => $collection->options

                ];
            }
        );

        $jsonCollection['count'] = $themeTagTypeCollection->count();
        $jsonCollection['result'] = $this->collectionHydrator;

        return $jsonCollection;
    }
}
