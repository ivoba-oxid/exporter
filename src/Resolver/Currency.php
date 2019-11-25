<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Config;

class Currency implements ResolverInterface
{

    private $config;

    /**
     * Currency constructor.
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }


    public function supports(): string
    {
        return 'currency';
    }

    public function resolve(array $data)
    {
        $cur = $this->config->getActShopCurrencyObject();

        return $cur->name;
    }

}