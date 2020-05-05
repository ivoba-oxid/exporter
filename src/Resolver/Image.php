<?php

namespace IvobaOxid\Exporter\Resolver;

use IvobaOxid\Exporter\Entity\Config;

class Image implements ResolverInterface
{
    private $config;
    private $field;
    private $imageKey;

    public function __construct(Config $config, string $field = 'image', string $imageKey = 'OXPIC1')
    {
        $this->config   = $config;
        $this->field = $field;
        $this->imageKey = $imageKey;
    }

    public function supports(): string
    {
        return $this->field;
    }

    public function resolve(array $data)
    {
        if (isset($data[$this->imageKey]) && !empty($data[$this->imageKey])) {
            $image = $data[$this->imageKey];
        }

        if (isset($image)) {
            return $this->config->getShopUrl().$this->config->getImgPath().$image;
        }

        return '';
    }
}
