<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ConfigService;
use Illuminate\Http\Request;


class ConfigLimitController extends ApiBtgController
{
    private $userHelper;
    private $configService;

     public function __construct(ConfigService $configService, UserHelper $userHelper)
    {
        $this->configService = $configService;
        $this->userHelper  = $userHelper;
    }
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-06-29]
    * @return  Json
    */
    public function configupdate(Request $request)
    {
        return $this->configService->updateconfig($this->userHelper, $request);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-06-29]
    * @return  Json
    */
    public function show()
    {
        return $this->configService->showConfig($this->userHelper);
    }
}
