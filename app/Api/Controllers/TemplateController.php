<?php

namespace Api\Controllers;

use Api\Helpers\UserHelper;
use Api\Services\TemplateService;
use Illuminate\Http\Request;

class TemplateController extends ApiBtgController
{
    private $userHelper;
    private $templateService;

    public function __construct(TemplateService $templateService, UserHelper $userHelper)
    {
        $this->templateService = $templateService;
        $this->userHelper = $userHelper;
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function index() {
        return $this->templateService->getTemplates($this->userHelper);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function show($id) {
        return $this->templateService->getTemplateById($this->userHelper, $id);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function destroy($id) {
        return $this->templateService->deleteTemplate($this->userHelper, $id);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-06-21]
     * @return  Json
     */
    public function store(Request $request) {
        return $this->templateService->saveTemplate($this->userHelper, $request->only('id', 'name', 'html'));
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-03-02]
     * @return  Json
     */
    public function preview(Request $request)
    {
        return $this->templateService->getPreview($this->userHelper, $request->only('id', 'configs', 'products', 'recomendations', 'html'));
    }


    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-03-02]
     * @return  Json
     */
    public function view(Request $request)
    {
        return $this->templateService->getView($this->userHelper, $request->only('template', 'theme', 'products'));
    }

    public function makeFakeProduct($recommendation = '')
    {
        return [
            'image' => 'http://www.imgweave.com/view/10877.png',
            'link' => 'http://www.btg360.com.br/',
            'name' => $recommendation.str_shuffle(str_pad('Freezer Horizontal Esmaltec 215 Litros Branco - EFH250', rand(20, 200), ' A ')),
            'price' => rand(400, 800),
            'priceFrom' => rand(400, 800)
        ];
    }


    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @see     [https://laravel.com/docs/5.4/controllers]
     * @package [Api\Controllers]
     * @since   [2017-07-06]
     * @return  Json
     */
    public function all() {
        return $this->templateService->getAllTemplates($this->userHelper);
    }
}
