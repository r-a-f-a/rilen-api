<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\VmtaService;
use Illuminate\Http\Request;

class VmtaController extends ApiBtgController
{
    private $userHelper;
    private $vmtaService;

    /**
     * VmtaController constructor.
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-08-31]
     * @param   UserHelper $userHelper
     * @param   VmtaService $vmtaService
     */
    public function __construct(
        UserHelper $userHelper,
        VmtaService $vmtaService
    )
    {
        $this->userHelper  = $userHelper;
        $this->vmtaService = $vmtaService;
    }

    /**
     * @author  [Michel Lima] <michel.lima@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-08-31]
     * @return  array
     */
    public function getVmtaList()
    {
        return $this->vmtaService->getVmtaList();
    }

    public function updateVmta(Request $request)
    {
        return $this->vmtaService->updateVmta($request);
    }
}
