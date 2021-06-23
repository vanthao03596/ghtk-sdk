<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Inventory extends AbstractApi
{
    /**
     * @link https://docs.giaohangtietkiem.vn/?http#l-y-danh-sa-ch-th-ng-tin-s-n-ph-m
     * 
     * @param array $parameters
     *
     * @return mixed
     */
    public function getProductInfo(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->get('/services/kho-hang/thong-tin-san-pham', $parameters);
    }

    private function createOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        
        $resolver->define('term')
            ->required()
            ->allowedTypes('string');

        return $resolver;
    }
}