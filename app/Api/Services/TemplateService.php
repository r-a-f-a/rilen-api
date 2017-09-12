<?php

namespace Api\Services;

use Api\Models\ThemeModel;
use Api\Models\ProductListModel;
use Api\Transformers\TemplateListTransformer;
use Api\Transformers\TemplateTransformer;
use Api\Filters\HeaderFilter;
use Api\Models\PealModel;
use Api\Models\TemplateModel;
use Illuminate\Support\Facades\View;
use TwigBridge\Facade\Twig;
use Illuminate\Support\Facades\Storage;

class TemplateService
{
    private $productListService;
    private $themeModel;
    private $templateModel;
    private $productListModel;

    public function __construct(
        TemplateListTransformer $templateListTransformer,
        TemplateTransformer $templateTransformer,
        TemplateModel $templateModel,
        ThemeModel $themeModel,
        HeaderFilter $headerFilter,
        ProductListService $productListService,
        ProductListModel $productListModel
    )
    {
        $this->templateListTransformer = $templateListTransformer;
        $this->templateTransformer = $templateTransformer;
        $this->themeModel = $themeModel;
        $this->headerFilter = $headerFilter;
        $this->templateModel = $templateModel;
        $this->productListModel = $productListModel;
        $this->productListService = $productListService;
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-21]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getTemplates(\Api\Helpers\UserHelper $userHelper)
    {
        $templateList = $this->templateModel->getTemplates($userHelper);

        if ($templateList->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->templateListTransformer->transform($templateList);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-21]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   int $id
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getTemplateById(\Api\Helpers\UserHelper $userHelper, $id)
    {
        $template = $this->templateModel->getTemplateById($userHelper, $id);

        if ($template->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->templateTransformer->transform($template);
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-21]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   int $id
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function deleteTemplate(\Api\Helpers\UserHelper $userHelper, $id)
    {
        $jsonCollection['status'] = $this->templateModel->deleteTemplate($userHelper, $id) > 0;

        return $jsonCollection;
    }

    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-06-21]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @param   array $parameters
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function saveTemplate(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        if (isset($parameters['id'])) {
            $result = $this->templateModel->updateTemplate($userHelper, $parameters);
        } else {
            $template = new TemplateModel();
            $template->name = $parameters['name'];
            $template->html = $parameters['html'];
            $template->userId = $userHelper->getUserId();
            $result = $template->save();
        }

        return response()->json(['status' => $result > 0], $result > 0 ? 200 : 400);
    }




    public function getView(\Api\Helpers\UserHelper $userHelper, $parameters)
    {
        $templates = $this->templateModel->getTemplateById($userHelper, $parameters['template'])->toArray();
        $theme = $this->themeModel->getThemeById($userHelper, $parameters['theme'])->toArray();
        if($theme && $templates){
            $themeSelected = json_decode($theme[0]['configs'], true);
            $data['configs'] =  collect($themeSelected)->except(['header','footer'])->toArray();
            $html = $themeSelected['header'] . $templates[0]['html'] . $themeSelected['footer'];
            if(!isset($parameters['products']) || $parameters['products'] > 10){
                $parameters['products'] = 10;
            }
            $products = $this->productListService->getRandom($userHelper, $parameters['products']);
            $data['products'] = $products;
            $data['recommendations'] = $products;
            $id = md5(time() . rand(1, 1000));
            $storage = Storage::disk('views');
            $templateName = 'twig/templates/tmp/' . $id;
            $storage->put($templateName . '.twig', $html);
            $view = view(str_replace('/', '.', $templateName), $data);
            $preview = html_entity_decode($view->render());
            $storage->delete($templateName . '.twig');
            return $preview;
        }

        return false;


    }

    public function getPreview(\Api\Helpers\UserHelper $userHelper, $parameters)
    {

        if ($parameters['html']) {
            $id = md5(time() . rand(1, 1000));
            $html = $parameters['html'];
        } else {
            $id = $parameters["id"];

            if (!isset($id) || strlen(trim($id)) == 0) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }

            $templates = $this->templateModel->getTemplateById($userHelper, $id);

            if ($templates->isEmpty()) {
                return $this->headerFilter->getEmptyResult();
            }

            $html = $templates['html'];
        }
        $configs = $parameters["configs"];

        $data = [];

        if (!isset($configs)) {
            $data['configs'] = [
                'font' => 'Arial',
                'titleSize' => rand(2, 4),
                'titleColor' => '#85C1E9',
                'priceSize' => rand(2, 3),
                'priceColor' => '#21618C',
                'prizeFromSize' => rand(1, 2),
                'priceFromColor' => '#21618C',
                'borderColor' => '#21618C',
                'backgroundColor' => '#ffffff',
                'buttonColor' => '  #85C1E9',
                'imageSize' => 180,
                'buttonType' => '1',
                'buttonText' => 'COMPRE AGORA',
                'buttonTextColor' => '#ffffff',
                'buttonImg' => 'http://img.comprarlipostabil.org/2016/04/botao-quero-comprar-1024x200.png',
                'buttonImgSize' => '180',
                'recommendationTitle' => htmlentities('Recomendamos para você'),
                'recommendationTitleColor' => '#FFFFFF',
                'recommendationDesc' => htmlentities('Abaixo segue alguns produtos que talvez você goste')
            ];
        } else {
            $data['configs'] = $configs;
        }
        $products = $this->productListService->getRandom($userHelper);
        $data['products'] = $products;
        $data['recommendations'] = $products;
        $storage = Storage::disk('views');
        $templateName = 'twig/templates/tmp/' . $id;
        $storage->put($templateName . '.twig', $html);
        $view = view(str_replace('/', '.', $templateName), $data);
        $preview = html_entity_decode($view->render());
        $storage->delete($templateName . '.twig');
        return $preview;
    }


    /**
     * @author  [Rafael Rodrigues] <rafael.rodrigues@locaweb.com.br>
     * @package [Api\Services]
     * @since   [2017-07-06]
     * @param   \Api\Helpers\UserHelper $userHelper
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTemplates(\Api\Helpers\UserHelper $userHelper)
    {
        $templateList = $this->templateModel->getAllTemplates($userHelper);

        if ($templateList->isEmpty()) {
            return $this->headerFilter->getEmptyResult();
        }

        return $this->templateListTransformer->transform($templateList);
    }

}
