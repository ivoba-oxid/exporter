<?php

namespace IvobaOxid\Exporter\Resolver;

use IvobaOxid\Exporter\Entity\Config;

class Image implements ResolverInterface
{
    private $config;

    /**
     * Image constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }


    public function supports(): string
    {
        return 'image';
    }

    public function resolve(array $data)
    {
        if (isset($data['OXPIC1']) && !empty($data['OXPIC1'])) {
            $image = $data['OXPIC1'];
        }

        if (isset($image)) {
            return $this->config->getShopUrl().$this->config->getImgPath().$image;
        }

        return '';
    }
}