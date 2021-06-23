<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Address extends AbstractApi
{
    /**
     * @link https://docs.giaohangtietkiem.vn/?http#l-y-danh-sa-ch-i-a-chi-c-p-4
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function getAddressLevel4(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->get('/services/address/getAddressLevel4', $parameters);
    }

    private function createOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->define('address')
            ->allowedTypes('string');
        
        $resolver->define('province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('district')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('ward_street')
            ->required()
            ->allowedTypes('string');

        return $resolver;
    }
}
