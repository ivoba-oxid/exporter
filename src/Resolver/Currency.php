<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Config;

class Currency extends BaseResolver
{

    private $config;

    /**
     * Currency constructor.
     * @param Config $config
     * @param string $supports
     */
    public function __construct(Config $config, string $supports)
    {
        $this->config = $config;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        return $this->config->getActShopCurrencyObject()->name;
    }
}
