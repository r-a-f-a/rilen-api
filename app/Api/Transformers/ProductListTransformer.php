<?php

namespace Api\Transformers;

use Api\Filters\HeaderFilter;
use Api\Helpers\UserHelper;
use Api\Hydrators\HydratorAbstract;

class ProductListTransformer extends HydratorAbstract
{
    /**
     * @author  [Lucas Rodrigues] <lucas.rodrigues@locaweb.com.br>
     * @package [Api\Transformers]
     * @since   [2017-06-23]
     * @param   \illuminate\Support\Collection $pealCollection
     * @param   int $totalCount
     * @return  Json
     */
    public function transformMultiple(\illuminate\Support\Collection $productCollection, $totalCount, $html = false) 
    {
        unset($this->products);

        if ($html) {
            $productCollection->transform(
                function ($product) {
                     $this->products[] = [
                         'attribute1' => $product->atributo1,
                         'attribute2' => $product->atributo2,
                         'attribute3' => $product->atributo3,
                         'attribute4' => $product->atributo4,
                         'attribute5' => $product->atributo5,
                         'availability' => $product->disponibilidade,
                         'barCode' => $product->codigo_barra,
                         'brand' => $product->marca,
                         'category' => $product->categoria,
                         'city' => $product->cidade,
                         'condition' => $product->condicoes,
                         'country' => $product->pais,
                         'establishment' => $product->estabelecimento,
                         'establishmentLink' => $product->link_estabelecimento,
                         'finalDate' => $product->data_fim,
                         'image' => $product->imagem,
                         'initDate' => $product->data_inicio,
                         'installment' => $product->parcelamento,
                         'installmentDesc' => $product->parcela,
                         'installmentValue' => $product->valor_parcela,
                         'otherOffersLink' => $product->link_outras_ofertas,
                         'productId' => $product->id_produto,
                         'price' => $product->preco,
                         'priceNum' => $product->preco_num,
                         'priceBy' => $product->preco_por,
                         'priceByNum' => $product->preco_por_num,
                         'productGroupId' => $product->id_grupo_produto,
                         'productDesc' => $product->nome_produto,
                         'productLink' => $product->link_produto,
                         'quantity' => $product->quantidade,
                         'state' => $product->estado,
                         'subCategory' => $product->sub_categoria,
                         'subCategoryTwo' => $product->sub_sub_categoria,
                         'totalQtySold' => $product->total_qtd_vendido,
                     ];
                }
            ); 
        } else {
            $productCollection->transform(
                function ($product) {
                    $this->products[] = [
                        'id' => $product->id_produto,
                        'name' => $product->nome_produto,
                        'image' => $product->imagem
                    ];
                }
            );
        }

        $jsonCollection['count'] = $productCollection->count();
        $jsonCollection['total'] = $totalCount;
        $jsonCollection['result'] = $this->products;

        return $jsonCollection;
    }


    public function transform(\illuminate\Support\Collection $productCollection)
    {
        unset($this->products);
        $productCollection->transform(
            function ($product) {
                $this->products[] = [
                    'attribute1' => $product->atributo1,
                    'attribute2' => $product->atributo2,
                    'attribute3' => $product->atributo3,
                    'attribute4' => $product->atributo4,
                    'attribute5' => $product->atributo5,
                    'availability' => $product->disponibilidade,
                    'barCode' => $product->codigo_barra,
                    'brand' => $product->marca,
                    'category' => $product->categoria,
                    'city' => $product->cidade,
                    'condition' => $product->condicoes,
                    'country' => $product->pais,
                    'establishment' => $product->estabelecimento,
                    'establishmentLink' => $product->link_estabelecimento,
                    'finalDate' => $product->data_fim,
                    'image' => $product->imagem,
                    'initDate' => $product->data_inicio,
                    'installment' => $product->parcelamento,
                    'installmentDesc' => $product->parcela,
                    'installmentValue' => $product->valor_parcela,
                    'otherOffersLink' => $product->link_outras_ofertas,
                    'productId' => $product->id_produto,
                    'price' => $product->preco,
                    'priceNum' => $product->preco_num,
                    'priceBy' => $product->preco_por,
                    'priceByNum' => $product->preco_por_num,
                    'productGroupId' => $product->id_grupo_produto,
                    'productDesc' => $product->nome_produto,
                    'productLink' => $product->link_produto,
                    'quantity' => $product->quantidade,
                    'state' => $product->estado,
                    'subCategory' => $product->sub_categoria,
                    'subCategoryTwo' => $product->sub_sub_categoria,
                    'totalQtySold' => $product->total_qtd_vendido,
                ];
            }
        );
        return $this->products;
    }
}