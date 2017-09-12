<?php

namespace Api\Services;

use App\Api\Models\RedirectorModel;

class RedirectorService
{
    protected $status = [
        "error" => false,
        "msg" => "",
        "url" => ""
    ];
    protected $redirectorModel;

    public function __construct(RedirectorModel $redirectorModel)
    {
        $this->redirectorModel = $redirectorModel;
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   UserHelper $userHelper
     * @param   array $urlData
     * @return  String
     */
    public function buildUrl($urlData)
    {
        //$this->saveUrlData($urlData);
        if(!array_key_exists('productLink', $urlData)) return;
        $url = base64_decode($urlData['productLink']);
        if(!$url) return;
        if(!array_key_exists('email', $urlData)) return;

        $arrayUtms = $this->queryStringInArray(base64_decode($urlData['email']));
        $parseUrl = parse_url($url);
        $this->makeUtms($parseUrl, $arrayUtms);

        $finalUtms = $this->makeUtms($parseUrl, $arrayUtms);
        return $this->reBuildUrl($parseUrl) . "?" . $finalUtms;
    }

    protected function makeUtms($parseUrl, $arrayUtms)
    {
        if(array_key_exists('query', $parseUrl)){
            $finalUtms = $this->urlWithQueryString($parseUrl, $arrayUtms);
        } else {
            $finalUtms = $this->urlNoQueryString($arrayUtms);
        }
        return $finalUtms;
    }

    protected function urlWithQueryString($parseUrl, $arrayUtms)
    {
        $urlQueryString = $this->queryStringInArray($parseUrl['query']);
        $totalReplacements = $this->replaceExistsValuesUtms($arrayUtms, $urlQueryString);

        if($totalReplacements == 0){
            $utms = $this->concatUtmsWithNewValues($urlQueryString, $arrayUtms);
        }else{
            $utms = $this->concatUtmValues($urlQueryString);
        }
        return $utms;
    }

    protected function urlNoQueryString($arrayUtms)
    {
        return $this->concatUtmValues($arrayUtms);
    }


    protected function saveUrlData($urlData)
    {
        $this->prepareUrlData($urlData);
    }

    protected function prepareUrlData($urlData)
    {
        if($this->validateUrlData($urlData)) {
            $urlData["createdAt"] = date('Y-m-d');
            $urlData["createdAtFull"] = date('Y-m-d H:i:s');
            $urlData['email'] = null;
            $urlData['productLink'] = base64_decode($urlData['productLink']);
            $this->redirectorModel->create($urlData);
        }
    }

    protected function validateUrlData($urlData)
    {
        $allData = (array_key_exists('btgId', $urlData) && $urlData['btgId'])
            && (array_key_exists('position', $urlData) && $urlData['position']>=0)
            && (array_key_exists('productId', $urlData) && $urlData['productId'])
            && (array_key_exists('productLink', $urlData) && $urlData['productLink']);
        if($allData) return true;
        return false;
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   array $parseUrl
     * @param   String $finalUtms
     * @return  String
     */
    protected function reBuildUrl($parseUrl)
    {
        $parseUrl['scheme'] = array_key_exists("scheme", $parseUrl) ? $parseUrl['scheme'] . "://" : "http://";
        $parseUrl['path'] = array_key_exists("path", $parseUrl) ? $parseUrl['path'] : "/";

        return $parseUrl['scheme'] . $parseUrl['host'] . $parseUrl['path'];
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   array $arrayUtms
     * @param   array $urlQueryString
     * @return  String
     */
    protected function replaceExistsValuesUtms($arrayUtms, &$urlQueryString)
    {
        $totalReplacements = 0;
        foreach($arrayUtms as $utms){
            $key = key($utms);
            foreach($urlQueryString as &$queryString){
                if(array_key_exists($key, $queryString)) {
                    $totalReplacements++;
                    $queryString[$key] = $utms[$key];
                }
            }
        }
        return $totalReplacements;
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   array $utms
     * @return  String
     */
    protected function concatUtmValues($utms)
    {
        $finalUtms = "";
        foreach($utms as $utm){
            $key = key($utm);
            $finalUtms .= $key . "=" . $utm[$key] . "&";
        }
        return substr($finalUtms, 0, strlen($finalUtms)-1);
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   array $arrayLinkUtms
     * @param   array $arrayConfiguredUtms
     * @return  String
     */
    protected function concatUtmsWithNewValues($arrayLinkUtms, $arrayConfiguredUtms)
    {
        $finalUtms = "";
        foreach($arrayLinkUtms as $linkUtm){
            $key = key($linkUtm);
            $finalUtms .= $key . "=" . $linkUtm[$key] . "&";
        }
        foreach($arrayConfiguredUtms as $configuredUtms){
            $key = key($configuredUtms);
            $finalUtms .= $key . "=" . $configuredUtms[$key] . "&";
        }
        return substr($finalUtms, 0, strlen($finalUtms)-1);
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-23]
     * @param   String $utm
     * @return  Array
     */
    protected function queryStringInArray($utm)
    {
        $arrayUtms = explode("&", $utm);
        $newArrayUtms = [];
        foreach($arrayUtms as $i => $utms){
            $keyValue = explode("=", $utms);
            $key = $keyValue[0];
            $value = $keyValue[1];
            $newArrayUtms[$i][$key] = $value;
        }
        return $newArrayUtms;
    }
}