<?php

namespace Api\Services;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Models\VmtaModel;
use Api\Transformers\VmtaTransformer;
use Api\Services\ConfigService;

class VmtaService
{
    private $headerFilter;
    private $userHelper;
    private $vmtaModel;
    private $vmtaTransformer;
    private $configService;

    /**
     * VmtaService constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2017-08-31]
     * @param   HeaderFilter $headerFilter
     * @param   UserHelper $userHelper
     * @param   VmtaModel $vmtaModel
     * @param   VmtaTransformer $vmtaTransformer
     */
    public function __construct(
        HeaderFilter $headerFilter,
        UserHelper $userHelper,
        VmtaModel $vmtaModel,
        VmtaTransformer $vmtaTransformer,
        ConfigService $configService
    )
    {
        $this->headerFilter = $headerFilter;
        $this->userHelper = $userHelper;
        $this->vmtaModel = $vmtaModel;
        $this->vmtaTransformer = $vmtaTransformer;
        $this->configService = $configService;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Services]
     * @since   [2017-08-31]
     * @return  array
     */
    public function getVmtaList()
    {
        $vmtaCollection = $this->vmtaModel->getVmtaListByIdAlliN($this->userHelper->getUserIdAlliN());

        if ($vmtaCollection->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->vmtaTransformer->transform($vmtaCollection);
    }

    public function updateVmta($request)
    {
        if (!$request->has('vmta')) {
            return false;
        }

        $vmta = $request->input('vmta');
        $userId = $this->userHelper->getUserId();

        return $this->configService->updateVmta($vmta, $userId);
    }
}
