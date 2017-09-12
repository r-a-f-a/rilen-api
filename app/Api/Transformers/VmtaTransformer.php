<?php

namespace Api\Transformers;

use Api\Hydrators\HydratorAbstract;

class VmtaTransformer extends HydratorAbstract
{
    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-08-31]
     * @param   \illuminate\Support\Collection $vmtaCollection
     * @return  Array
     */
    public function transform(\illuminate\Support\Collection $vmtaCollection)
    {
        $vmtaCollection->transform(
            function ($vmta) {

                if (!is_null($vmta->vmta) && !empty($vmta->vmta)) {
                    $this->vmta['vmta'] = $vmta->vmta;
                }

                if (!is_null($vmta->vmtaInactive) && !empty($vmta->vmtaInactive)) {
                    $this->vmta['vmtaInactive'] = $vmta->vmtaInactive;
                }

                if (!is_null($vmta->vmtaInactive2) && !empty($vmta->vmtaInactive2)) {
                    $this->vmta['vmtaInactive2'] = $vmta->vmtaInactive2;
                }

                if (!is_null($vmta->vmtaInactive3) && !empty($vmta->vmtaInactive3)) {
                    $this->vmta['vmtaInactive3'] = $vmta->vmtaInactive3;
                }

                if (!is_null($vmta->vmtaInactive4) && !empty($vmta->vmtaInactive4)) {
                    $this->vmta['vmtaInactive4'] = $vmta->vmtaInactive4;
                }

                if (!is_null($vmta->vmtaProspect) && !empty($vmta->vmtaProspect)) {
                    $this->vmta['vmtaProspect'] = $vmta->vmtaProspect;
                }

                if (!is_null($vmta->vmtaTrans) && !empty($vmta->vmtaTrans)) {
                    $this->vmta['vmtaTrans'] = $vmta->vmtaTrans;
                }
            }
        );

        $jsonCollection['count'] = $vmtaCollection->count();
        $jsonCollection['result'] = array_unique($this->vmta);

        return $jsonCollection;
    }
}
