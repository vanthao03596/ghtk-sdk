<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Order extends AbstractApi
{
    /**
     * @link https://docs.giaohangtietkiem.vn/?http#ng-n-h-ng
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function createOrder(array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();

        $parameters = $resolver->resolve($parameters);

        return $this->post('/services/shipment/order', $parameters);
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/?php#tr-ng-th-i-n-h-ng
     *
     * @param string $label
     *
     * @return mixed
     */
    public function checkStatus(string $label)
    {
        return $this->get("/services/shipment/v2/$label");
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/?php#h-y-n-h-ng
     *
     * @param string $label
     *
     * @return mixed
     */
    public function cancelOrder(string $label)
    {
        return $this->post("/services/shipment/cancel/$label");
    }

    /**
     * @link https://docs.giaohangtietkiem.vn/?php#in-nh-n-n-h-ng
     *
     * @param string $label
     *
     * @return mixed
     */
    public function printLabel(string $label)
    {
        return $this->get("/services/label/$label", [], [
            'Accept' => '*/*',
        ]);
    }

    private function createOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();

        $resolver->setDefault('order', function (OptionsResolver $orderResolver) {
            // Pick Info

            $orderResolver->define('id')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_name')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_money')
                    ->required()
                    ->allowedTypes('int');

            $orderResolver->define('pick_address_id')
                    ->allowedTypes('string');

            $orderResolver->define('pick_address')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_province')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_district')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_ward')
                    ->allowedTypes('string');

            $orderResolver->define('pick_street')
                    ->allowedTypes('string');

            $orderResolver->define('pick_tel')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('pick_email')
                    ->allowedTypes('string');

            // Receive Info

            $orderResolver->define('name')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('address')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('province')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('district')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('ward')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('street')
                    ->allowedTypes('string');

            $orderResolver->define('hamlet')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('tel')
                    ->required()
                    ->allowedTypes('string');

            $orderResolver->define('note')
                    ->allowedTypes('string');

            $orderResolver->define('email')
                    ->required()
                    ->allowedTypes('string');

            // Return info

            $orderResolver->define('use_return_address')
                ->allowedTypes('int')
                ->allowedValues(0, 1)
                ->default(0);

            $orderResolver->define('return_name')
                ->allowedTypes('string');

            $orderResolver->define('return_address')
                ->allowedTypes('string');

            $orderResolver->define('return_province')
                ->allowedTypes('string');

            $orderResolver->define('return_district')
                ->allowedTypes('string');

            $orderResolver->define('return_ward')
                ->allowedTypes('string');

            $orderResolver->define('return_street')
                ->allowedTypes('string');

            $orderResolver->define('return_tel')
                ->allowedTypes('string');

            $orderResolver->define('return_email')
                ->allowedTypes('string');

            // Extra info

            $orderResolver->define('is_freeship')
                ->allowedTypes('int')
                ->allowedValues(0, 1);

            $orderResolver->define('weight_option')
                ->allowedTypes('string')
                ->allowedValues('gram', 'kilogram');

            $orderResolver->define('total_weight')
                ->allowedTypes('double');

            $orderResolver->define('pick_work_shift')
                ->allowedTypes('int')
                ->allowedValues(3, 2, 1);

            $orderResolver->define('deliver_work_shift')
                ->allowedTypes('int')
                ->allowedValues(3, 2, 1);

            $orderResolver->define('label_id')
                ->allowedTypes('string');

            $orderResolver->define('pick_date')
                ->allowedTypes('string');

            $orderResolver->define('deliver_date')
                ->allowedTypes('string');

            $orderResolver->define('expired')
                ->allowedTypes('string');

            $orderResolver->define('value')
                ->allowedTypes('int');

            $orderResolver->define('opm')
                ->allowedTypes('int')
                ->allowedValues(1, 0);

            $orderResolver->define('pick_option')
                ->allowedTypes('string')
                ->allowedValues('cod', 'post');

            $orderResolver->define('actual_transfer_method')
                ->allowedTypes('string');

            $orderResolver->define('transport')
                ->allowedTypes('string')
                ->allowedValues('road', 'fly');

            $orderResolver->define('deliver_option')
                ->allowedTypes('string');

            $orderResolver->define('pick_session')
                ->allowedTypes('string');

            $orderResolver->define('tags')
                ->allowedTypes('int[]');
        });

        $resolver->setDefault('products', function (OptionsResolver $productResolver) {
            $productResolver
                ->setPrototype(true)
                ->setRequired(['name', 'weight', 'product_code'])
                ->setDefined(['price', 'quantity'])
                ->setAllowedTypes('name', 'string')
                ->setAllowedTypes('price', 'int')
                ->setAllowedTypes('weight', 'double')
                ->setAllowedTypes('quantity', 'int')
                ->setAllowedTypes('product_code', ['int', 'string']);
        });

        return $resolver;
    }
}
