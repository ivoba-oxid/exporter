<?php

namespace IvobaOxid\Exporter\Resolver;

use IvobaOxid\Exporter\Entity\Config;

class Price implements ResolverInterface
{

    private $config;

    /**
     * Price constructor.
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function supports(): string
    {
        return 'oxprice';
    }

    public function resolve(array $data)
    {
        if ($this->config->getNetPrices()) {
            // general vat
            $vat = $this->config->getDefaultVat();

            // if product (parent /child) has own vat
            if (isset($data['OXVAT']) && !empty($data['OXVAT'])) {
                $vat = $data['OXVAT'];
            }

            $price = $data['OXPRICE'];
            $price += $price * $vat / 100;

            return round($price, 2);
        }

        return $data['OXPRICE'];
    }
}