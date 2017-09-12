<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;

class ReportTransformer extends HydratorAbstract
{

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-08-22]
     * @param   \illuminate\Support\Collection $reportCollection
     * @return  mixed
     */
    public function transformReport($reportCollection)
    {
        $reportCollection->transform(
            function ($collection) {
                $this->collectionHydrator[] = [
                    'userRuleId'    => $collection->userRuleId,
                    'sendDate'      => $collection->sendDate,
                    'sendHour'      => $collection->sendHour,
                    'sends'         => $collection->sends,
                    'sumClick'      => $collection->sumClick,
                    'openings'      => $collection->openings,
                    'rule'          => $collection->rule,
                    'ruleName'      => $collection->ruleName
                ];
            }
        );

        $jsonCollection['count'] = $reportCollection->count();
        $jsonCollection['result']['items'] = $this->collectionHydrator;

        $paginate = $reportCollection->toArray();
        $jsonCollection['result']['total']          = $paginate['total'];
        $jsonCollection['result']['perPage']        = $paginate['per_page'];
        $jsonCollection['result']['current_page']   = $paginate['current_page'];
        $jsonCollection['result']['last_page']      = $paginate['last_page'];
        $jsonCollection['result']['next_page_url']  = $paginate['next_page_url'];
        $jsonCollection['result']['prev_page_url']  = $paginate['prev_page_url'];
        $jsonCollection['result']['from']           = $paginate['from'];
        $jsonCollection['result']['to']             = $paginate['to'];

        return $jsonCollection;
    }
}
