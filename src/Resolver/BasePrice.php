<?php

namespace IvobaOxid\Exporter\Resolver;

class BasePrice implements ResolverInterface
{

    private $priceResolver;

    /**
     * BasePrice constructor.
     * @param ResolverInterface $priceResolver
     */
    public function __construct(ResolverInterface $priceResolver)
    {
        $this->priceResolver = $priceResolver;
    }

    public function supports(): string
    {
        return 'baseprice';
    }

    public function resolve(array $data)
    {
        $unitQuantity = floatval($data['OXUNITQUANTITY']);
        if ($unitQuantity  !== 0.0) {
            return round($this->priceResolver->resolve($data) / $unitQuantity, 2);
        }

        return 0;
    }

}