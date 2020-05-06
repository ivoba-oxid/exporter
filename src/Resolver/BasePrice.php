<?php

namespace IvobaOxid\Exporter\Resolver;

class BasePrice extends BaseResolver
{
    /**
     * @var ResolverInterface
     */
    private $priceResolver;

    /**
     * BasePrice constructor.
     * @param ResolverInterface $priceResolver
     * @param string $supports
     */
    public function __construct(ResolverInterface $priceResolver, string $supports)
    {
        $this->priceResolver = $priceResolver;
        parent::__construct($supports);
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
