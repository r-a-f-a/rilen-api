<?php

namespace Api\Services;

use Api\Transformers\ConfigGlobalsTransformer;
use Api\Transformers\ConfigTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\GlobalUserModel;
use Api\Models\GlobalOptionModel;
use Api\Models\GlobalModel;
use Api\Models\ConfigModel;
use Illuminate\Http\Request;


class ConfigService
{
    private $globalUserModel;

    public function __construct(
        ConfigGlobalsTransformer $configGlobalsTransformer,
        ConfigTransformer $configTransformer,
        GlobalUserModel $globalUserModel,
        HeaderFilter $headerFilter,
        GlobalOptionModel $globalOptionModel,
        GlobalModel $globalModel,
        ConfigModel $configModel
    )
    {
        $this->configGlobalsTransformer = $configGlobalsTransformer;
        $this->configTransformer = $configTransformer;
        $this->headerFilter = $headerFilter;
        $this->globalUserModel = $globalUserModel;
        $this->globalOptionModel = $globalOptionModel;
        $this->globalModel = $globalModel;
        $this->configModel = $configModel;
    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper , Illuminate\Http\Request $request
     * @return  json
     */
    public function createOrderGlobals(\Api\Helpers\UserHelper $userHelper, Request $request)
    {

        if (!$request->has('data')) {
            return $this->headerFilter->getMissingEntity("Missing params", ['data']);
        }
        $data = $request->input('data');
        if (!is_array($data)) {
            $data = \GuzzleHttp\json_decode($data, true);
        }

        $globalUser = new GlobalUserModel();
        $globals = new GlobalModel();
        foreach ($data as $key => $val) {
            $global = $globals->getConfig($key);
            $globalTransform = $this->configGlobalsTransformer->globalTransform($global, true);
            $attributes = [
                'userId' => $userHelper->getUserId(),
                'globalId' => $globalTransform['id'],
                'value' => $val,
            ];
            $globalUser::insertUpdate($attributes);
        }

        $json["status"] = true;
        return $json;
    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-27]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  json
     */
    public function listConfigsGlobals(\Api\Helpers\UserHelper $userHelper)
    {

        $configGlobalsOptionsList = $this->globalUserModel->getConfigGlobalsOptionsList($userHelper);

        if ($configGlobalsOptionsList->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->configGlobalsTransformer->transform($configGlobalsOptionsList, true);

    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-29]
     * @param   \Api\Helpers\UserHelper $userHelper , Illuminate\Http\Request $request
     * @return  json
     */
    public function updateconfig(\Api\Helpers\UserHelper $userHelper, Request $request)
    {
        $config = $this->configModel->configById($userHelper->getUserId());
        $config->limit = ($request->has("limit")) ? $request->input("limit") : $config->limit;
        $config->btg = ($request->has("btg")) ? $request->input("btg") : $config->btg;

        $json["status"] = $config->save() > 0;
        return $json;

    }

    /**
     * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-29]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  json
     */
    public function showConfig(\Api\Helpers\UserHelper $userHelper)
    {
        $config = $this->configModel->showConfig($userHelper->getUserId());
        if ($config->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->configTransformer->transform($config, true);

    }

    public function updateVmta($vmta, $userId)
    {
        return $this->configModel->updateVmta($vmta, $userId);
    }


}
