<?php

namespace Api\Controllers;

use Illuminate\Http\Request;
use Api\Services\RedirectorService;

class RedirectorController extends ApiBtgController
{
    protected $userHelper, $redirectorService;

    public function __construct(RedirectorService $redirectorService)
    {
        $this->redirectorService = $redirectorService;
    }

    /**
     * @author  [Will] <willians.silva@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-07-17]
     * @return  \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $url = $this->redirectorService->buildUrl($request->all());
        if ($url) {
            return redirect($url);
        }
    }
}