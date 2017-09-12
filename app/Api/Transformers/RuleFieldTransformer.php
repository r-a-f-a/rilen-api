<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;


class RuleFieldTransformer extends HydratorAbstract
{

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $fieldCollection
     * @return  Json
     */
    public function transform(\illuminate\Support\Collection $fieldCollection)
    {
        unset($this->collectionHydrator);
        $fieldCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'sourceId' => $collection->sourceId,
                    'name' => $collection->name,
                    'title' => $collection->title,
                    'type' => $collection->type,
                    'placeholder' => $collection->placeholder,
                    'required' => $collection->required,
                    'help' => $collection->help,
                    'mask' => $collection->mask,
                    'order' => $collection->order,
                ];

            }
        );

        return $this->collectionHydrator;
    }


    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/eloquent]
     * @package [Api\Models]
     * @since   [2017-06-23]
     * @param   array $collection
     * @return  array
     */
    public function fieldDefault($collection)
    {
        if (isset($collection['required'])) {
            $collection['required'] = true;
        }

        return $transformer = [
            'name' => $collection['name'],
            'title' => $collection['title'],
            'type' => $collection['type'],
            'placeholder' => $collection['placeholder'],
            'required' => $collection['required'],
            'mask' => $collection['mask'],
            'help' => $collection['help'],
            'order' => $collection['order'],
        ];
    }

    /**
     * @author  [Juliana Fernandes] <juliana.fernandes@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-22]
     * @param   \illuminate\Support\Collection $ruleGroupCollection
     * @return  Json
     */
    public function transformGroups(\illuminate\Support\Collection $ruleGroupCollection)
    {
        $ruleGroupCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = $collection->groupId;
            }
        );

        return $this->collectionHydrator;
    }
}
