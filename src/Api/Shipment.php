<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Shipment extends AbstractApi
{
    /**
     * @link https://docs.giaohangtietkiem.vn/?http#t-nh-ph-v-n-chuy-n
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function calculateFee(array $parameters = [])
    {
        $resolver = $this->createCalculateFeeOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->get('/services/shipment/fee', $parameters);
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/#l-y-danh-sa-ch-i-a-chi-l-y-ha-ng
     *
     * @return mixed
     */
    public function listPickAddress()
    {
        return $this->get('/services/shipment/list_pick_add');
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/?http#api-check-d-ch-v-xfast
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function checkXteam(array $parameters = [])
    {
        $resolver = $this->createCheckXteamOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->get('/services/shipment/x-team', $parameters);
    }

    private function createCheckXteamOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->define('pick_province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('pick_district')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('pick_ward')
            ->allowedTypes('string');
        
        $resolver->define('pick_street')
            ->allowedTypes('string');
        
        $resolver->define('customer_province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('customer_district')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('customer_ward')
            ->allowedTypes('string');
        
        $resolver->define('customer_street')
            ->allowedTypes('string');

        $resolver->define('customer_first_address')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('customer_hamlet')
            ->allowedTypes('string');

        return $resolver;
    }

    private function createCalculateFeeOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->define('pick_address_id')
            ->allowedTypes('string');
        
        $resolver->define('pick_address')
            ->allowedTypes('string');

        $resolver->define('pick_province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('pick_district')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('pick_ward')
            ->allowedTypes('string');

        $resolver->define('pick_street')
            ->allowedTypes('string');
        
        $resolver->define('address')
            ->allowedTypes('string');
        
        $resolver->define('province')
            ->required()
            ->allowedTypes('string');
        
        $resolver->define('district')
            ->required()
            ->allowedTypes('string');

        $resolver->define('ward')
            ->allowedTypes('string');
        
        $resolver->define('street')
            ->allowedTypes('string');
        
        $resolver->define('weight')
            ->required()
            ->allowedTypes('int');
        
        $resolver->define('value')
            ->allowedTypes('int');
        
        $resolver->define('transport')
            ->allowedTypes('string')
            ->allowedValues('road', 'fly');
        
        $resolver->define('deliver_option')
            ->required()
            ->allowedTypes('string')
            ->allowedValues('xteam', 'none');

        $resolver->define('tags')
            ->allowedTypes('array')
            ->allowedTypes('int[]');


        return $resolver;
    }
}
