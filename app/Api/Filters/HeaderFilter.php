<?php

namespace Api\Filters;

class HeaderFilter
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Filters]
    * @since   [2017-02-22]
    * @return  Response
    */
    public function getEmptyResult()
    {
        return response([], 204);
    }
    /**
    * @author  [Ely Galdino] <ely.galdino@locaweb.com.br>
    * @package [Api\Filters]
    * @since   [2017-06-29]
    * @param   array $msg 
    * @return  Response
    */
    public function getInvalidRequest($msg)
    {
        return response($msg, 400);
    }

    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Filters]
     * @since   [2017-06-29]
     * @param   string $msg
     * @param   array $params
     * @return Response
     */
    public function getMissingEntity($msg,$params)
    {
        $response = [
            'message' => $msg,
            'params' => $params
        ];
        return response($response, 422);
    }
}
