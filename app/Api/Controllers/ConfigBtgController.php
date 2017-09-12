<?php
namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\ConfigService;
use Illuminate\Http\Request;


class ConfigBtgController extends ApiBtgController
{
    private $userHelper;
    private $configService;

     public function __construct(ConfigService $configService, UserHelper $userHelper)
    {
        $this->configService = $configService;
        $this->userHelper  = $userHelper;
    }
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @see     [https://laravel.com/docs/5.4/controllers]
    * @package [Api\Controllers]
    * @since   [2017-03-30]
    * @return  Json
    */
    public function index()
    {
        return response()->json(['btg' => false]);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-27]
    * @return  Json
    */
    public function createorderglobal(Request $request){
        return $this->configService->createOrderGlobals($this->userHelper, $request);
    }

    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-06-27]
    * @return  Json
    */
    public function listglobals(){
        return $this->configService->listConfigsGlobals($this->userHelper);
    }
}
