<?php

namespace IvobaOxid\Exporter\Resolver;

class ShippingFee implements ResolverInterface
{

    private $priceResolver;

    /**
     * ShippingFee constructor.
     * @param ResolverInterface $priceResolver
     */
    public function __construct(ResolverInterface $priceResolver)
    {
        $this->priceResolver = $priceResolver;
    }

    public function supports(): string
    {
        return 'shippingfee';
    }

    public function resolve(array $data)
    {

        /*
         * Todo can we get this from the DB?
         * OXFREESHIPPING
         * + load Versandkostenregeln
         */
        $shippingcost = [
            [
                'from' => 0,
                'cost' => 4.9,
            ],
        ];
        $productPrice = $this->priceResolver->resolve($data);
        $marker  = 0;
        for ($i = 0; $i < count($shippingcost); $i++) {
            if ($productPrice >= $shippingcost[$i]['from']) {
                $marker = $i;
            }
        }

        return $shippingcost[$marker]['cost'];
    }

}