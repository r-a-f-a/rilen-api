<?php

namespace Api\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;

class UserHelper
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Helpers]
    * @since   [2016-02-13]
    * @return  int
    */
    public function getUserId()
    {
        return JWTAuth::parseToken()->authenticate()->id;
    }

    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Helpers]
    * @since   [2016-02-13]
    * @return  String
    */
    public function isHomologation()
    {
        return JWTAuth::parseToken()->authenticate()->homologation;
    }

    /**
    * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
    * @package [Api\Helpers]
    * @since   [2016-06-22]
    * @return  String
    */
    public function getUserIdAlliN()
    {
        return JWTAuth::parseToken()->authenticate()->allinId;
    }


    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Helpers]
     * @since   [2017-08-21]
     * @return  String
     */
    public function getUser()
    {
        $account =  new \StdClass();
        $account->id = JWTAuth::parseToken()->authenticate()->id;
        $account->btgId = JWTAuth::parseToken()->authenticate()->btgId;
        $account->allinId = JWTAuth::parseToken()->authenticate()->allinId;
        $account->token = JWTAuth::parseToken()->authenticate()->token;
        return $account;
    }
}
