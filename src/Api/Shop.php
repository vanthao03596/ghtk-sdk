<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Shop extends AbstractApi
{
    /**
     * @link https://docs.giaohangtietkiem.vn/?php#t-o-t-i-kho-n
     * 
     * @param array $parameters
     *
     * @return mixed
     */
    public function create(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->get('/services/shops/add', $parameters);
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/?php#t-i-kho-n-ng-k-tr-c
     * 
     * @param array $parameters
     *
     * @return mixed
     */
    public function getToken(array $parameters)
    {
        $resolver = new OptionsResolver();

        $resolver->define('email')
            ->required()
            ->allowedTypes('string');
    
        $resolver->define('password')
            ->required()
            ->allowedTypes('string');

        $parameters = $resolver->resolve($parameters);

        return $this->post('/services/shops/token', $parameters);
    }

    private function createOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->define('name')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('first_address')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('district')
            ->required()
            ->allowedTypes('string');

        $resolver->define('tel')
            ->required()
            ->allowedTypes('string');

        $resolver->define('email')
            ->required()
            ->allowedTypes('string');

        return $resolver;
    }
}